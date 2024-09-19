<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvImportRequest;
use App\Http\Requests\ShopRequest;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

class ManagerController extends Controller
{
/*    public function __construct()
    {
        $this->middleware('permission:edit shop')->only(['editDetail', 'updateDetail']);
        $this->middleware('permission:create shop')->only(['addShop', 'createShop']);
        $this->middleware('permission:check reservations')->only('viewReservations');
    }*/

    public function selectShop($action)
    {
        $user = Auth::user();
        $shops = $user->shops;

        return view('manager/select_shop', [
            'shops' => $shops,
            'action' => $action,
        ]);
    }

    public function viewReservations(Request $request, Shop $shop)
    {
        $thisDate = $request->query('date') ? new Carbon($request->query('date')) : Carbon::today();
        $prevDate = $thisDate->copy()->subDay();
        $nextDate = $thisDate->copy()->addDay();

        $shopReservations = Reservation::where('shop_id', $shop->id);
        $thisDateReservations = $shopReservations
            ->whereDate('date', $thisDate->toDateString())
            ->orderBy('time')
            ->get();

        return view('manager/view_reservations', compact(
            'shop',
            'thisDate',
            'prevDate',
            'nextDate',
            'thisDateReservations'
        ));
    }

    public function editDetail(Shop $shop)
    {
        $areas = Area::all();
        $genres = Genre::all();
        $storageImages = Storage::files('public/images');

        return view('manager/edit_shop_detail', compact(
            'shop',
            'areas',
            'genres',
            'storageImages',
        ));
    }

    public function updateDetail(ShopRequest $request, Shop $shop)
    {
        $shop = $request->shop;

        if ($request->hasFile('upload_image')) {
            $path = $request->file('upload_image')->store('public/images');
            $shop->image_path = str_replace('public', '', $path);
        } else {
            $imagePath = $request->input('image_path');
            if ($imagePath) {
                $shop->image_path = str_replace('public', '', $imagePath);
            }
        }

        $shop->name = $request->input('name');
        $shop->area_id = $request->input('area_id');
        $shop->genre_id = $request->input('genre_id');
        $shop->detail = $request->input('detail');
        $shop->save();

        return redirect()->back();
    }

    public function addShop()
    {
        $areas = Area::all();
        $genres = Genre::all();
        $storageImages = Storage::files('public/images');

        return view('manager/add_shop', compact(
            'areas',
            'genres',
            'storageImages',
        ));
    }

    public function createShop(ShopRequest $request)
    {
        if ($request->area_id == 'new') {
            $area = Area::create(['name' => $request->newArea]);
            $request->merge(['area_id' => $area->id]);
        }

        if ($request->genre_id == 'new') {
            $genre = Genre::create(['name' => $request->newGenre]);
            $request->merge(['genre_id' => $genre->id]);
        }

    $data = $request->all();

        if ($request->hasFile('upload_image')) {
            $path = $request->file('upload_image')->store('public/images');
            $data['image_path'] = $path;
        }

        $data['image_path'] = str_replace('public', '', $data['image_path']);

        $shop = Shop::create($data);

        $user = Auth::user();

        DB::table('shop_user')->insert([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
        ]);

        return redirect('/');
    }

    public function addShopWithCsv()
    {
        return view('manager/csv');
    }

    public function checkCsv(CsvImportRequest $request)
    {
        $errors = new MessageBag();

        //画像アップロード
        if ($request->hasFile('imgs')) {
            $sameImgUrlErrors = [];
            foreach ($request->file('imgs') as $img) {
                $imgName = $img->getClientOriginalName();
                $filePath = 'public/images/' . $imgName;

                //同一の画像名の存在の有無
                if (Storage::exists($filePath)) {
                    $sameImgUrlErrors[] = 'ストレージ内に同じ画像URLが存在します: ' . $imgName;
                } else {
                    $img->storeAs('public/images', $imgName);
                }
            }

            if (!empty($sameImgUrlErrors)) {
                $errors->merge(['same_img_url_errors' => $sameImgUrlErrors]);
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

        //CSVデータのバリデーション
        $validateErrors = $this->validateCsvData($csvData);

        if (!is_null($validateErrors)) {
            $errors->merge(['csv_errors' => $validateErrors->getBag('default')->all()]);
        }

        // 画像の存在確認
        $imgErrors = [];
        foreach ($csvData as $key => $row) {
            $imgName = $row[3];
            $filePath = 'public/images/' . basename($imgName);

            if (!Storage::exists($filePath)) {
                $imgErrors[] = ($key + 1) . "行目の画像をアップロード、またはストレージ内の画像URLを指定してください: " . $imgName;
            }
        }

        if (!empty($imgErrors)) {
            $errors->merge(['img_errors' => $imgErrors]);
        }

        if ($errors->isNotEmpty()) {
            return redirect()->back()->withErrors($errors);
        }

        return view(
            'manager.csv_preview',
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
