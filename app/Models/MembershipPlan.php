<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'duration_months',
        'max_classes', 'personal_trainer', 'is_active',
    ];

    protected $casts = [
        'personal_trainer' => 'boolean',
        'is_active'        => 'boolean',
        'price'            => 'decimal:2',
    ];

    public function memberships()
    {
        return $this->hasMany(Membership::class, 'plan_id');
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
