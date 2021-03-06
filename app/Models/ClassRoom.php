<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    protected $table = 'classes';

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
