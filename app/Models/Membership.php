<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'plan_id', 'start_date', 'end_date', 'status', 'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function plan()
    {
        return $this->belongsTo(MembershipPlan::class, 'plan_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function isExpired(): bool
    {
        return $this->end_date->isPast();
    }
}
