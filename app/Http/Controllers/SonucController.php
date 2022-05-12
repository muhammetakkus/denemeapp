<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sonuc;
use App\Models\Deneme;
use App\Models\User;
use App\Models\AnswerKey;
use Barryvdh\DomPDF\Facade\Pdf;

class SonucController extends Controller
{
  public function store(Request $request)
  {
    $fields = $request->validate([
      'result' => 'required|string',
      'user_id' => 'required',
      'deneme_id' => 'required',
    ]);

    // Eğer deneme daha önce okunmuşsa update yapacak yeniden kayıt oluşturmasın !
    $find = Sonuc::where('deneme_id', $request->deneme_id)->where('user_id', $request->user_id)->count();

    if ($find) {
      $sonuc = Sonuc::where('deneme_id', $request->deneme_id)->where('user_id', $request->user_id)->first();
      $sonuc->sonuc = $fields['result'];
    } else {
      $sonuc = new Sonuc([
        'sonuc' => $fields['result'],
        'user_id' => $request->user_id,
        'deneme_id' => $request->deneme_id,
      ]);

      /* Sonuç kaydı yaparken Deneme tablosunda is_answer = 1 yap ve okundu olarak anlaşılsın */
      $deneme = Deneme::find($request->deneme_id);
      $deneme->is_answer = 1;
      $deneme->save();
    }

    return $sonuc->save();
  }

  // DOWNLOAD - SIRALI LİSTE -
  public function generatePDF($deneme_id, $user_id) {
    $sonuc = Sonuc::where('deneme_id', $deneme_id)->where('user_id', $user_id)->first();
    if (count(json_decode($sonuc->sonuc)) == 0) {
      return response()->json([
          'error' => 'Sonuç verisi bulunamadı.'
      ]);
    }

    $user = User::find($user_id);
    $deneme = Deneme::find($deneme_id);

    $pdf = PDF::loadView('sonuc', [
      'sonuc' => json_decode($sonuc->sonuc),
      'user' => $user,
      'deneme' => $deneme
      ])->setPaper('a4', 'landscape');

    // return $pdf->download('sonuc.pdf');

    $path = public_path('pdf/');
    $fileName =  time() . '.' . 'pdf' ;
    $pdf->save($path . '/' . $fileName);
    $pdf = public_path('pdf/'.$fileName);
    return response()->download($pdf);
  }

  // DOWNLOAD - ANSWER KEY -
  public function answerkey($deneme_id, $user_id) {
    $answer = AnswerKey::where('deneme_id', $deneme_id)->first();
    $deneme = Deneme::find($deneme_id);

    $pdf = PDF::loadView('answerkey', [
      'answer' => json_decode($answer->answer_key),
      'deneme' => $deneme
      ]);

    $path = public_path('pdf/');
    $fileName =  time() . '.' . 'pdf' ;
    $pdf->save($path . '/' . $fileName);
    $pdf = public_path('pdf/'.$fileName);
    return response()->download($pdf);
  }
}
