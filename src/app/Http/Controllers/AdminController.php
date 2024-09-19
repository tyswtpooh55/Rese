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
}
