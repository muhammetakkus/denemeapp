<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OptikForm;

use App\Exports\AnswerKeyLayout;
use Maatwebsite\Excel\Facades\Excel;

class OptikFormController extends Controller
{
  public function store(Request $request)
  {
    $fields = $request->validate([
      'optik_form_name' => 'required|string',
      'optik' => 'required|string',
    ]);

    $optik = new OptikForm([
        'optik_form_name' => $fields['optik_form_name'],
        'optik' => $fields['optik'],
        'user_id' => $request->user_id,
    ]);

    return $optik->save();
  }

  /* user_id = 0 olan optik formlar admin tarafından eklenen bütün kullanclarda görülen optik form şablonlarıdır */
  public function myOwnOptikForms($id)
  {
    $myOwnOptikler = OptikForm::where('user_id', $id)->orWhere('user_id', 0)->orderByDesc('created_at')->get();
    return response()->json($myOwnOptikler);
  }

  public function show($id)
  {
    $optik = OptikForm::find($id);
    return response()->json($optik);
  }

  public function all()
  {
    $optikler = OptikForm::all();
    return response()->json($optikler);
  }

  public function update(Request $request)
  {
    $optik = OptikForm::find($request->id);

    $fields = $request->validate([
      'optik_form_name' => 'required|string',
      'optik' => 'required|string',
    ]);

    $optik->optik_form_name = $fields['optik_form_name'];
    $optik->optik = $fields['optik'];

    return $optik->save();
  }

  public function delete(Request $request)
  {
    $optik = OptikForm::find($request->id);
    return $optik->delete();
  }

  public function downloadAnswerKeyLayout()
  {
    $file = public_path() . '/file/answer_key_layout.xlsx';
    return response()->download($file);
  }
}
