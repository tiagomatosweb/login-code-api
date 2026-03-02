<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Http\Requests\VerifyLoginCodeRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyLoginCodeController extends Controller
{
    public function __invoke(VerifyLoginCodeRequest $request)
    {
        $inputs = $request->validated();

        $user = User::where('email', $inputs['email'])->first();

        if (!$user) {
            throw new AuthException('InvalidOrExpiredCode', 401);
        }

        $loginCode = $user->loginCodes()
            ->where('code', $inputs['code'])
            ->where('expires_at', '>', now())
            ->first();

        if (!$loginCode) {
            throw new AuthException('InvalidOrExpiredCode', 401);
        }

        auth()->login($user);
        
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }
            
        $user->loginCodes()->delete();

        return new UserResource($user);
    }
}
