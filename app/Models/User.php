<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'lastname',
        'password',
        'roles',
        'is_active',
        'email',
        'email_verified_at',
        'image',
        'tel',
    ];

    protected $casts = [
        'roles' => 'array',
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'tel' => $this->tel,
            'image' => $this->image,
            'roles' => $this->roles,
            'is_active' => $this->is_active,
        ];
    }
}
