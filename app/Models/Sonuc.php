<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sonuc extends Model
{
    use HasFactory;

    protected $table = 'sonuc';

    protected $fillable = [
        'sonuc',
        'user_id',
        'deneme_id'
    ];

    public function deneme()
    {
        return $this->belongsTo(Deneme::class);
    }
}
