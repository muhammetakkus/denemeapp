<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    /* Register */
    public function register(Request $request) {
      $fields = $request->validate([
        'username' => 'required|string|unique:users,username',
        'first_name' => 'required|string',
        'second_name' => 'required|string',
        'email' => 'required|string|unique:users,email',
        'password' => 'required|string',
        'kurum_name' => 'required|string',
        // 'kurum_gsm' => 'required|integer',
      ]);

      $user = User::create([
        'username' => $fields['username'],
        'first_name' => $fields['first_name'],
        'second_name' => $fields['second_name'],
        'email' => $fields['email'],
        'password' => Hash::make($fields['password']),
        'kurum_name' => $fields['kurum_name'],
        'kurum_gsm' => $request->kurum_gsm
      ]);

      /* geçici test */
      // $user = User::create([
      //   'username' => $request['username'],
      //   'first_name' => 'asdasd',
      //   'second_name' => 'asdasd',
      //   'email' => 'a@a.com',
      //   'password' => Hash::make($request['password']),
      //   'kurum_name' => '123123',
      //   'kurum_gsm' => '123123',
      // ]);

      $token = $user->createToken($request['username'])->plainTextToken;

      $response = [
        'user' => $user,
        'token' => $token
      ];

      return response($response, 201);
    }

    /* Login */
    public function login(Request $request) {
      $fields = $request->validate([
        'username' => 'required|string|max:200',
        // 'email' => 'required|string',
        'password' => 'required|string|max:200',
      ]);

      $user = User::where('username', $fields['username'])->first();

      if (!$user || !Hash::check($fields['password'], $user['password'])) {
        return response([
          'error' => 'Kullanıcı Adı veya Şifre Hatalı'
        ]);
      }

      $token = $user->createToken($request['username'])->plainTextToken;

      $response = [
        'user' => $user,
        'token' => $token
      ];

      return response($response, 201);
    }

    public function logout(Request $request) {
      // auth()->user()->tokens()->delete();
      $request->user()->currentAccessToken()->delete();

      return [
        'message' => 'logged out'
      ];
    }

    public function getUser(){
      return \Auth::user();
    }
}
