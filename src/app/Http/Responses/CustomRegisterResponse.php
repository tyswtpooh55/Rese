<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Symfony\Component\HttpFoundation\Response;

class CustomRegisterResponse implements RegisterResponseContract
{
    public function toResponse($request): Response
    {
        // 登録後のリダイレクト先を指定
        return redirect()->route('thanks');
    }
}