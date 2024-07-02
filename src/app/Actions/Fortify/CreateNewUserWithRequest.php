<?php

namespace App\Actions\Fortify;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUserWithRequest implements CreatesNewUsers
{
    public function create(array $input)
    {
        $request = App::make(RegisterRequest::class);
        $request->merge($input);
        $request->validateResolved();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
        return $user;
    }
}
