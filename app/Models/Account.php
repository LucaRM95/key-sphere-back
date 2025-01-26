<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'provider', 'provider_account_id', 
        'refresh_token', 'access_token', 'expires_at', 'token_type', 
        'scope', 'id_token', 'session_state'
    ];

    protected $casts = [
        'expires_at' => 'integer',
        'refresh_token' => 'string',
        'access_token' => 'string',
        'id_token' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Add unique constraint to provider and provider_account_id
    public static function boot()
    {
        parent::boot();

        static::creating(function ($account) {
            $account->unique(['provider', 'provider_account_id']);
        });
    }
}
