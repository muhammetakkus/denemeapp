<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
  /* Register */
  public function createAdmin(Request $request) {
    /* web.php den get requesti açıp get yap ve admin oluştur */
    $admin = Admin::create([
      'username' => 'mehmetakkus',
      'first_name' => 'Mehmet',
      'second_name' => 'Akkuş',
      'email' => 'mehmetakkus.mail@gmail.com',
      'password' => Hash::make('123123'),
    ]);

    return $admin;
  }

  /* Login */
  public function login(Request $request) {
    $fields = $request->validate([
      'username' => 'required|string',
      // 'email' => 'required|string',
      'password' => 'required|string',
    ]);

    $admin = Admin::where('username', $fields['username'])->first();

    if (!$admin || !Hash::check($fields['password'], $admin['password'])) {
      return response([
        'error' => 'Kullanıcı Adı veya Şifre Hatalı'
      ]);
    }

    $token = $admin->createToken($request['username'])->plainTextToken;

    $response = [
      'admin' => $admin,
      'admin_token' => $token
    ];

    return response($response, 201);
  }

  public function logout(Request $request) {
    $request->user()->currentAccessToken()->delete();

    return [
      'message' => 'logged out'
    ];
  }
}
