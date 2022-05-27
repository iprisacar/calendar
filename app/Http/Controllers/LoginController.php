<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $request->validate([
                'email'=>['required','email'],
                'password'=>['required']
            ]);
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email'=> ['The providers credentials is incorrect']
            ]);
        }

        return  $user->createToken('Auth token')->plainTextToken;
    }
}
