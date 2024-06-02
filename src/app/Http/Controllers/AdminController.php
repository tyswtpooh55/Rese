<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManagerRequest;
use App\Http\Requests\SendEmailRequest;
use App\Models\Role;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function viewManagers()
    {
        $managers = User::whereHas('role', function ($query) {
            $query->where('role_name', 'shop_manager');
        })->orderBy('shop_id')->get();

        $shops = Shop::all();

        return view('admin/view_managers', compact(
            'managers',
            'shops',
        ));
    }

    public function deleteManager($id)
    {
        User::find($id)->delete();

        return back();
    }

    public function createManager(ManagerRequest $request)
    {
        $shopManagerRole = Role::where('role_name', 'shop_manager')->first();

        User::create([
            'name' => $request->name,
            'role_id' => $shopManagerRole->id,
            'shop_id' => $request->shop_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.viewManagers');
    }

    public function writeEmail()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('role_name', 'customer');
        })->get();

        return view('admin/write_emails', compact('users'));
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
            $customers = User::whereHas('role', function($query) {
                $query->where('role_name', 'customer');
            })->get();
        } else {
            $customers = User::whereIn('id', $recipients)->whereHas('role', function ($query) {
                $query->where('role_name', 'customer');
            })->get();
        }

        foreach ($customers as $customer) {
            Mail::raw($message, function ($msg) use ($customer, $subject) {
                $msg->to($customer->email)->subject($subject);
            });
        }

        return redirect()->back()->with('success', 'メールを送信しました');
    }
}
