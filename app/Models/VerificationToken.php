<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationToken extends Model
{
    use HasFactory;

    protected $fillable = ['identifier', 'token', 'expires'];

    protected $casts = [
        'expires' => 'datetime',
    ];

    public $timestamps = false; // Disable automatic timestamps
}
