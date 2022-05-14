<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class KurumController extends Controller
{
  public function kurumlar()
  {
    return User::all();
  }

  public function delete(Request $request)
  {
    $kurum = User::find($request->id);
    return $kurum->delete();
  }

  public function change_status(Request $request)
  {
    $kurum = User::find($request->id);

    if ($kurum->is_confirm) {
      $kurum->is_confirm = 0;
    } else {
      $kurum->is_confirm = 1;
    }

    $kurum->save();

    return $kurum->is_confirm;
  }
}
