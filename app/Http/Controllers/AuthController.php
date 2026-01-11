<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|string|min:1|max:255",
            "password" => "required|string|min:1|max:255"
        ]);

        $user = User::where("email", $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                "message" => ["not email and password of database"]
            ]);
        }
        $token = $user->createToken('default')->plainTextToken;
        $user->token = $token;

        return response()->json([
            "status" => true,
            "message" => "success login",
            "data" => $user
        ], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            "full_name" => "required|string|min:1|max:255",
            "email" => "required|string|email|min:1|max:255",
            "phone_number" => [
                "required",
                "string",
                "regex:#^(\+62|0)[0-9]{9,13}$#"
            ],
            "password" => "required|string|min:1|max:255",
            "confirm_password" => "required|string|min:1|max:255"
        ]);

        $CreateAccounr = User::create([
            "full_name" =>  $request->full_name,
            "email" => $request->email,
            "phone_number" => $request->phone_number,
            "password" => bcrypt($request->password),
        ]);

        try {
            if (!$CreateAccounr) {
                return response()->json([
                    "status" => false,
                    "message" => "Gagal Register"
                ]);
            } else {
                return response()->json([
                    "status" => true,
                    "message" => "sucess Register",
                    "data" => $CreateAccounr
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "gagal API",
                "error" => report($th)
            ], 500);
        }
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            "status" => false,
            "message" => "Success Logout"
        ], 200);
    }
}
