<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'address', 'description', 'lat', 'lng', 'images', 'type', 
        'status', 'is_active', 'price', 'area', 'beds', 'baths', 'user_id'
    ];

    protected $casts = [
        'images' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_active' => 'boolean',
        'price' => 'float',
        'area' => 'float',
        'lat' => 'float',
        'lng' => 'float',
    ];

    protected $keyType = 'string';
    
    // Disable auto-incrementing
    public $incrementing = false;
    
    // Automatically generate UUID for new records
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid(); // Generate UUID if not set
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
