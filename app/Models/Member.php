<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone',
        'date_of_birth', 'gender', 'address',
        'emergency_contact_name', 'emergency_contact_phone',
        'photo', 'status',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'date_of_birth' => 'date',
        'password'      => 'hashed',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function activeMembership()
    {
        return $this->hasOne(Membership::class)
            ->where('status', 'active')
            ->latest();
    }

    public function classBookings()
    {
        return $this->hasMany(ClassBooking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
