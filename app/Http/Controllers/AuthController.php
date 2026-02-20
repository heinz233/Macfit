<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:40',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4|max:15|confirmed'
        ]);

        try {

            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']); // ✅ Save password

            $user->save();

            return response()->json([
                'message' => 'Registration Successful',
                'user' => $user
            ], 201);

        } catch (\Exception $exception) {

            return response()->json([
                'error' => "Registration Failed!",
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email', // ✅ fixed
            'password' => 'required|string|min:4'
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'error' => ['Invalid Credentials']
            ]);
        }

        $token = $user->createToken("auth-token")->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => "Login Successful!",
            'user' => $user
        ], 200);
    }
}
