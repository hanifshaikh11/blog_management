<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // User Login
    public function login(Request $request)
    {
        // Validation
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first(); // check user from DB
        if (!empty($user)) {

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid Password'
                ]);
            }

            $token = $user->createToken('API_TOKEN')->plainTextToken;
            return response()->json([
                'status'  => true,
                'message' => 'Login Successfully',
                'token'   => $token,
                'user'    => $user
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid Email'
            ]);
        }
    }


    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete(); // token

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}
