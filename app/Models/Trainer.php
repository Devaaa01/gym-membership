<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone',
        'specialization', 'bio', 'photo', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function classes()
    {
        return $this->hasMany(GymClass::class, 'trainer_id');
    }
}
