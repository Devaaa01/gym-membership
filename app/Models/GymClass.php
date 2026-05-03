<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'trainer_id', 'name', 'description', 'category',
        'schedule', 'duration_minutes', 'max_capacity', 'room', 'status',
    ];

    protected $casts = [
        'schedule' => 'datetime',
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }

    public function bookings()
    {
        return $this->hasMany(ClassBooking::class, 'class_id');
    }

    public function getAvailableSpotsAttribute(): int
    {
        return $this->max_capacity - $this->bookings()->whereIn('status', ['booked', 'attended'])->count();
    }

    public function isFullAttribute(): bool
    {
        return $this->available_spots <= 0;
    }
}
