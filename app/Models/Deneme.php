<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deneme extends Model
{
    use HasFactory;

    protected $table = 'denemeler';

    protected $fillable = [
        'deneme_name',
        'deneme_type',
        'uygulama_tarihi',
        'kac_yanlis_bir_dogru',
        'user_id',
        'dublicated',
        'period_id',
        'is_answer',
        'is_primary',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function answerkey()
    {
        return $this->hasOne(AnswerKey::class, 'deneme_id');
    }

    public function sonuc()
    {
        return $this->hasOne(Sonuc::class, 'deneme_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
