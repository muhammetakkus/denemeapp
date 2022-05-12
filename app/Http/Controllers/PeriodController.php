<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;

class PeriodController extends Controller
{
  public function store(Request $request)
  {
    $fields = $request->validate([
      'period' => 'required|string|unique:periods,period',
    ]);

    $period = new Period([
        'period' => $fields['period'],
        // 'period' => $request->input('period'),
    ]);
    return $period->save();
  }

  public function getActivePeriod()
  {
    $period = Period::where('is_active', 1)->first();
    return $period; 
  }

  public function show($id)
  {
    $period = Period::find($id);
    return response()->json($period);
  }

  public function all()
  {
    $periods = Period::all();
    return response()->json($periods);
  }

  public function update(Request $request)
  {
    $period = Period::find($request->id);
    if ($request->status == 1) {
      return false;
    } else if ($request->status == 0) {
      $active_period = Period::where('is_active', 1)->first();
      if ($active_period) {
        $active_period->is_active = 0;
        $active_period->save();
      }

      $period->is_active = 1;
      $period->save();
    }
    return true;
  }

  public function delete(Request $request)
  {
    $period = Period::find($request->id);
    return $period->delete();
  }
}
