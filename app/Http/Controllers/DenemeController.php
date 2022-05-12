<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deneme;
use App\Models\AnswerKey;
use App\Models\Period;

class DenemeController extends Controller
{
  public function store(Request $request)
  {
    $fields = $request->validate([
      'deneme_name' => 'required|string',
      'deneme_type' => 'required|string',
      'kac_yanlis_bir_dogru' => 'required|integer|max:5',
    ]);

    $active_period = app('App\Http\Controllers\PeriodController')->getActivePeriod();

    $deneme = new Deneme([
        'deneme_name' => $fields['deneme_name'],
        'deneme_type' => $fields['deneme_type'],
        'uygulama_tarihi' => $request->uygulama_tarihi,
        'kac_yanlis_bir_dogru' => $fields['kac_yanlis_bir_dogru'],
        'user_id' => $request->user_id,
        'dublicated' => 0,
        'period_id' => $active_period->id,
        'is_primary' => 1,
    ]);

    $deneme->save();

    return $deneme;
  }

  // Create External Deneme - Deneme Uygula
  public function duplicateDeneme(Request $request)
  {
    $active_period = app('App\Http\Controllers\PeriodController')->getActivePeriod();

    $is_there = Deneme::where('user_id', $request->user_id)->where('dublicated', $request->deneme['id'])->first();

    if (!$is_there) {
      $deneme = new Deneme([
          'deneme_name' => $request->deneme['deneme_name'],
          'deneme_type' => $request->deneme['deneme_type'],
          // 'uygulama_tarihi' => $request->uygulama_tarihi,
          'kac_yanlis_bir_dogru' => $request->deneme['kac_yanlis_bir_dogru'],
          'user_id' => $request->user_id,
          'dublicated' => $request->deneme['id'],
          'period_id' => $active_period->id,
          'is_primary' => 0,
      ]);

      $deneme->save();

      return $deneme->id;
    } else {
      /* Deneme Daha Önce Uygulanmışsa Bir Daha Oluşturma ID 'i dönder ki sonuc okuma metodu o id'e göre sonçları kaydetsin */
      return $is_there->id;
    }


  }

  public function denemeler(Request $request)
  {
    $active_period = app('App\Http\Controllers\PeriodController')->getActivePeriod();

    // Modeldeki relations'ı da beraber çekmek için with kullan
    $allDenemeByPeriod = Deneme::with('answerkey')->where('period_id', $active_period->id)->where('is_answer', 1)->where('is_primary', 1)->orderByDesc('created_at')->paginate(10);
    return response()->json($allDenemeByPeriod);
  }

  public function getActivePeriodDenemeler($period, Request $request)
  {
    $period = Period::where('period', $period)->first();
    $q = $request->q ?? null; // search text

    if ($q && $q != '') {

      $allDenemeByPeriod = Deneme::with('answerkey')
      ->where('period_id', $period->id)
      ->where([
        ['is_answer', 1],
        ['is_primary', 1],
      ])
      ->where('deneme_name', 'LIKE', "%{$q}%")
      // ->orWhere('deneme_type', 'LIKE', "%{$q}%") // orWhere devreye girince diğer where parametreleri yokmuş gibi arama yapıyor
      ->orderByDesc('created_at')
      ->paginate(10);
      return response()->json($allDenemeByPeriod);

    } else {
      // Modeldeki relations'ı da beraber çekmek için with kullan
      $allDenemeByPeriod = Deneme::with('answerkey')->where('period_id', $period->id)->where('is_answer', 1)->where('is_primary', 1)->orderByDesc('created_at')->paginate(10);
      return response()->json($allDenemeByPeriod);
    }
  }

  public function myOwnDenemeler($id)
  {
    // Modeldeki relations'ı da beraber çekmek için with kullan
    $myOwnDenemeler = Deneme::with(['period', 'answerkey', 'sonuc'])->where('user_id', $id)->orderByDesc('created_at')->get();
    return response()->json($myOwnDenemeler);
  }

  public function show($id)
  {
    $deneme = Deneme::find($id);
    return response()->json($deneme);
  }

  public function all()
  {
    $denemeler = Deneme::all();
    return response()->json($denemeler);
  }

  public function update(Request $request)
  {
    $deneme = Deneme::find($request->id);
    return $deneme->save();
  }

  public function delete(Request $request)
  {
    $deneme = Deneme::find($request->id);
    return $deneme->delete();
  }

  /**/
  public function storeAnswerKey(Request $request)
  {
    $find = AnswerKey::where('deneme_id', $request->deneme_id)->count();
    $deneme = Deneme::find($request->deneme_id);

    if ($find) {
      $answer = AnswerKey::where('deneme_id', $request->deneme_id)->first();
      $answer->answer_key = $request->answer_key;
    } else {
      $answer = new AnswerKey([
          'answer_key' => $request->answer_key,
          'deneme_id' => $request->deneme_id,
      ]);

      $deneme->is_answer = 1;
      $deneme->save();
    }

    return $answer->save();
  }

  public function getAnswerKey($deneme_id)
  {
    $answer = AnswerKey::where('deneme_id', $deneme_id)->first();
    return response()->json($answer);
  }

}
