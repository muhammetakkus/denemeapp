<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function classroom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
