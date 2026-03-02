<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestLoginCodeRequest;
use App\Models\User;
use App\Notifications\LoginCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RequestLoginCodeController extends Controller
{
    public function __invoke(RequestLoginCodeRequest $request)
    {
        $inputs = $request->validated();
        
        $user = User::where('email', $inputs['email'])->first();
        if ($user) {
            $code = Str::upper(Str::random(6));
            $user->loginCodes()->create([
                'code' => $code,
                'expires_at' => now()->addMinutes(15),
            ]);

            $user->notify(new LoginCodeNotification($code));
        }

        return response()->noContent();
    }
}
