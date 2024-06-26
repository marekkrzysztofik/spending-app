<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()->first()
            ];
            return response()->json($response, 400);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        event(new \App\Events\UserCreated($user->id));
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['id'] = $user->id;
        $success['name'] = $user->name;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => "User registered successfully"
        ];

        return response()->json($response, 200);
    }
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['id'] = $user->id;
            $success['name'] = $user->name;
            $response = [
                'success' => true,
                'data' => $success, 
                'message' => "User logged successfully"
            ];
            return response()->json($response, 200);
        }
        return response()->json(['success' => false, 'message' => 'Invalid email or password'], 401);
    }

    public function getUsers()
    {
        return User::all();
    }
}
