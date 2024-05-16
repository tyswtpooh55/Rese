<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

class CustomUserController extends RegisteredUserController
{
    public function redirectTo() {
        return route('auth/thanks');
    }
}
