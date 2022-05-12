<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer_key',
        'deneme_id'
    ];

    public function deneme()
    {
        return $this->belongsTo(Deneme::class);
    }
}
