<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'membership_id', 'amount', 'payment_method',
        'status', 'reference_number', 'payment_date', 'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount'       => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($payment) {
            if (empty($payment->reference_number)) {
                $payment->reference_number = 'PAY-' . strtoupper(Str::random(8));
            }
        });
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
