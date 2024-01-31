<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MondayToken extends Model
{
    protected $fillable = [
        'access_token',
    ];
}
