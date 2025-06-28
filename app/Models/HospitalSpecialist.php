<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HospitalSpecialist extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'specialist_id'
    ];

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function Specialitst(): BelongsTo
    {
        return $this->belongsTo(Specialist::class);
    }
}
