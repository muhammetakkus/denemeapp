<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'period'
    ];

    public function denemeler()
    {
        return $this->hasMany(Deneme::class, 'period_id');
    }
}
