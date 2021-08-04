<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'clinic_id',
        'doctor_id',
        'time',
        'date',
        'status'
    ];

    /**
     * Get array of values for the enum fields.
     *
     * @param String $field
     * @return Array
     */
    public static function getEnumValues(String $field = '')
    {
        switch ($field) {
            case 'status':
                return ['waiting', 'canceled', 'absence', 'done'];
                break;

            default:
                return [];
                break;
        }
    }

    public function scopeWaiting($query)
    {
        return $query->where('status', 'waiting');
    }

    /** Relationships  */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    /**** End Relationships ****/

    public function getTimeInFormatAttribute()
    {
        return Carbon::parse($this->attributes['time'])->format(config('appGlobals.time_format'));
    }
}
