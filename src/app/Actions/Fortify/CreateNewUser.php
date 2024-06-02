<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        
        Validator::make($input, [
            'name' => ['required', 'string', 'max:191'],
            'email' => [
                'required',
                'string',
                'email',
                'max:191',
                Rule::unique(User::class),
            ],
//            'password' => $this->passwordRules(),
            'password' => ['required', 'string', 'min:8', 'max:191'],
        ])->validate();
        
        /*$request = new RegisterRequest();
        $request -> merge($input);
        $request ->validate();*/

        $role_id = Role::where('role_name', 'customer')->firstOrFail()->id;

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role_id' => $role_id,
            'shop_id' => null,
        ]);
    }
}
