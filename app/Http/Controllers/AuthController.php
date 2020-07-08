<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', '=', $request->email)->firstOrFail();
        $status = "error";
        $message = "";
        $data = null;
        $code = 401;

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $user->generateToken();
                $status = 'Success';
                $message = 'Login Success';

                $data = $user->toArray();
                $code = 200;
            } else {
                $message = "Login Failure, incorrect password";
            }
        } else {
            $message = "Login Failure, incorrect username";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code); 
    }   
    
    public function register(Request $request) {
        $validator = Validator::make($request-> all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $status = "error";
        $message = "";
        $data = null;
        $code = 400;

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = $errors;
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'roles' => json_encode(['CUSTOMER']),
            ]);

            if ($user) {
                $user->generateToken();
                $status = "Success";
                $message = "Register Successfully";
                $data = $user->toArray();
                $code = 200;
            } else {
                $message = "Register Failed";
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function logout(Request $request) {
        $user = Auth::user();
        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'logout success',
            'data' => null
        ], 200);
    }
}
