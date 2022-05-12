<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptikForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'optik_form_name',
        'optik',
        'user_id',
    ];
}
