<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvImportRequest;
use App\Http\Requests\ManagerRequest;
use App\Http\Requests\SendEmailRequest;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

class AdminController extends Controller
{
/*    public function __construct()
    {
        $this->middleware('permission:manage manager')->only(['viewManagers', 'deleteManager','createManager']);
        $this->middleware('permission:send email')->only(['writeEmail', 'sendEmail']);
    }*/

    public function viewManagers()
    {
        $managers = User::role('manager')
            ->with('shops')
            ->get();

        $shops = Shop::all();

        return view('admin/view_managers', compact(
            'managers',
            'shops',
        ));
    }

    public function deleteManager(Request $request)
    {
        $userId = $request->input('user_id');
        $shopId = $request->input('shop_id');

        $manager = User::find($userId);

        if ($manager->shops()->count() > 1) {
            //複数店舗の責任者の場合、shop_userテーブルから関係を削除
            DB::table('shop_user')->where('user_id', $userId)
                ->where('shop_id', $shopId)
                ->delete();
        } else {
            //１つの店舗のみの場合、ユーザー自体を削除
            $manager->delete();
        }

        return back();
    }

    public function createManager(ManagerRequest $request)
    {
        $manager = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        $manager->assignRole('manager');

        DB::table('shop_user')->insert([
            'shop_id' => $request->shop_id,
            'user_id' => $manager->id,
        ]);

        return redirect()->route('admin.viewManagers');
    }

    public function writeEmail()
    {
        $customers = User::doesntHave('roles')->get();

        return view('admin/write_emails', compact('customers'));
    }

    public function sendEmail(SendEmailRequest $request)
    {
        $recipients = $request->input('recipients', []);
        $subject = $request->input('subject');
        $message = $request->input('message');

        if (in_array('all', $recipients) && count($recipients) >1) {
            return redirect()->back()->withInput()->withErrors(['error' => 'All Customersと個別Customerが同時に選択されています']);
        }

        $customers = [];
        if (in_array('all', $recipients)) {
            $customers = User::doesntHave('roles')->get();
        } else {
            $customers = User::whereIn('id', $recipients)->get();
        }

        foreach ($customers as $customer) {
            Mail::raw($message, function ($msg) use ($customer, $subject) {
                $msg->to($customer->email)->subject($subject);
            });
        }

        return redirect()->back()->with('success', 'メールを送信しました');
    }

    public function addShop()
    {
        return view('admin/csv');
    }

    public function checkCsv(CsvImportRequest $request)
    {
        if ($request->hasFile('imgs')) {
            foreach ($request->file('imgs') as $img) {
                $imgName = $img->getClientOriginalName();
                $filePath = 'public/images/' . $imgName;
                if (Storage::exists($filePath)) {
                    return back()->withErrors(['same_img_error' => 'ストレージ内に同じ名前のファイルが存在します: ' . $imgName]);
                } else {
                $img->storeAs('public/images', $imgName);
                }
            }
        }

        $csvFile = $request->file('csvFile');
        $path = $csvFile->getRealPath();

        //ファイルを開く
        $fp = fopen($path, 'r');

        //ヘッダー行をスキップ
        $csvHeader = fgetcsv($fp);

        $csvData = [];

        //1行ずつ読み込む
        while (($row = fgetcsv($fp)) !== false) {
            $csvData[] = $row;
        }

        fclose($fp);

        $validateErrors = $this->validateCsvData($csvData);

        if (!is_null($validateErrors)) {
            session()->flash('errors', $validateErrors);
            return back();
        }

        // 画像の存在確認
        $imageErrors = [];
        foreach ($csvData as $key => $row) {
            $imgName = $row[3];
            $filePath = 'public/images/' . basename($imgName);

            if (!Storage::exists($filePath)) {
                $imgErrors[] = ($key + 1) . "行目の画像をアップロード、またはストレージ内の画像URLを指定してください: " . $imgName;
            }
        }

        if (!empty($imgErrors)) {
            $errors = new ViewErrorBag();
            $messages = new MessageBag(['img_errors' => $imageErrors]);
            $errors->put('default', $messages);

            session()->flash('errors', $errors);

            return back()->withErrors(['img_errors' => $imgErrors]);
        }

        return view('admin.csv_preview',
            compact(
                'path',
                'csvHeader',
                'csvData',
            )
        );
    }

    private function validateCsvData(array $csvData): ?ViewErrorBag
    {
        $error_list = [];

        foreach ($csvData as $key => $value) {
            //バリデーションルール
            $rules = [
                //店舗名
                '0' => ['required', 'string', 'max:50'],
                //地域
                '1' => ['required', 'string', 'exists:areas,name'],
                //ジャンル
                '2' => ['required', 'string', 'exists:genres,name'],
                //画像URL
                '3' => ['required', 'string', 'regex:/\.(jpeg|png|jpg)$/'],
                //店舗概要
                '4' => ['required', 'string', 'max:400'],
            ];

            $messages = [
                '0.required' => '店舗名が空欄です',
                '0.max' => '店舗名は:max文字以内で入力してください',
                '1.required' => '地域が空欄です',
                '1.exists' => '地域は、「東京都」「大阪府」「福岡県」のみ有効です',
                '2.required' => 'ジャンルが空欄です',
                '2.exists' => 'ジャンルは、「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のみ有効です',
                '3.required' => '画像URLが空欄です',
                '3.regex' => '画像URLはjpegまたはpng形式のみ有効です',
                '4.required' => '店舗概要が空欄です',
                '4.max' => '店舗概要は:max文字以内で入力してください',
            ];

            $attributes = [
                '0' => '店舗名',
                '1' => '地域',
                '2' => 'ジャンル',
                '3' => '画像URL',
                '4' => '店舗概要',
            ];

            $validator = Validator::make($value, $rules, $messages, $attributes);

            if ($validator->fails()) {
                $errorMessage = array_map(function ($message) use ($key) {
                    return ($key + 1) . "行目: {$message}";
                }, $validator->errors()->all());
                $error_list = array_merge($error_list, $errorMessage);
            }
        }

        if (empty($error_list)) {
            return null;
        }

        $errors = new ViewErrorBag();
        $messages = new MessageBag(['upload_errors' => $error_list]);
        $errors->put('default', $messages);

        return $errors;
    }

    public function importCsv(Request $request)
    {
        $csvData = json_decode($request->input('csvData'), true);


        foreach ($csvData as $data) {
            $area = Area::where('name', $data[1])->first();
            $genre = Genre::where('name', $data[2])->first();
            $image_path = 'images/' . $data[3];

            Shop::create([
                'name' => $data[0],
                'area_id' => $area->id,
                'genre_id' => $genre->id,
                'image_path' => $image_path,
                'detail' => $data[4],
            ]);
        }
        return redirect('/');
    }
}
