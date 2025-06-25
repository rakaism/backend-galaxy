<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'salary',
        'bonus',
        'pph',
        'total',
        'status',
        'approved_by',
        'approved_at',
        'paid_by',
        'paid_at',
        'payment_proof',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}