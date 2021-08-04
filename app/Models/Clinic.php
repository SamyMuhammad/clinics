<?php

namespace App\Models;

use App\Helpers\CommonMethods;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clinic extends Model
{
    use HasFactory, CommonMethods;

    protected $fillable = [
        'ar_name',
        'en_name',
    ];

    public function doctors()
    {
        return $this->belongsToMany(User::class, 'clinic_doctor', 'clinic_id', 'doctor_id')
                    ->using(ClinicDoctor::class)
                    ->withPivot('day_name', 'shift_start_time', 'shift_end_time')
                    ->withTimestamps();
    }

    /**
     * Get all of the reservations for the Clinic
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
