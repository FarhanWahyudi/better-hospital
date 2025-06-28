<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class BookingTransaction extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'status',
        'started_at',
        'time_at',
        'sub_total',
        'tax_total',
        'grand_total',
        'proof',
    ];

    protected $cast = [
        'started_at' => 'date',
        'time_at' => 'datetime:H:i'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function getProofAttribute($value)
    {
        if (!$value) {
            return null;
        }

        return url(Storage::url($value));
    }
}
