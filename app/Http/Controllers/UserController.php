<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller

{
    public function signup(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);

        # code...
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        //Create Token;
        $token = $user->createToken('mytoken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,

        ]);
        //  "token": "1|Bb25YlUVcBxi0bo2t75EBO5IifuXWja6V0RNOymz"
        // Jimin : "token": "2|onEupQdR6fcU3QccgQQmsNZ4TZaVWFCzfwfLxkb5"
    }
    public function logout(Request $request) 
    {
        auth()->user()->tokens()->delete();
        
        return response()->json(['message' => 'User logged out']);
    }
    public function login(Request $request) 
    {
        # check email
        $userData = User::where('email', $request->email)->first();

        // Check password
        if (!$userData || !Hash::check($request->password, $userData->password)) {
            return response()->json(['message' => 'Bad login']);
        }
        //Create Token;
        $token = $userData->createToken('mytoken')->plainTextToken;

        return response()->json([
            'user' => $userData,
            'token' => $token,

        ]);
    }

}