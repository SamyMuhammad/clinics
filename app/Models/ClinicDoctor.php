<?php

namespace App\Models;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClinicDoctor extends Pivot
{
    protected $table = 'clinic_doctor';
    protected $fillable = [
        'clinic_id',
        'doctor_id',
        'day_name',
        'shift_start_time',
        'shift_end_time',
    ];

    /** Start relationships methods. */
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
    /** End relationships methods. */

    /**
     * return shift_start_time in the correct format.
     */
    public function getStartTimeAttribute()
    {
        if(is_null($this->shift_start_time)) return null;
        return Carbon::parse($this->shift_start_time)->format(config('appGlobals.time_format'));
    }

    /**
     * return shift_end_time in the correct format.
     */
    public function getEndTimeAttribute()
    {
        if(is_null($this->shift_end_time)) return null;
        return Carbon::parse($this->shift_end_time)->format(config('appGlobals.time_format'));
    }

    /**
     * Get numbers of hours between shift_start_time and shift_end_time.
     */
    public function getWorkIntervalAttribute()
    {
        if(is_null($this->shift_start_time) || is_null($this->shift_end_time)) return null;

        $start = Carbon::parse($this->shift_start_time);
        $end = Carbon::parse($this->shift_end_time);
        return $start->diffInHours($end);
    }

    /**
     * Divide the shift time into time slots.
     */
    public function getWorkTimeSlotsAttribute()
    {
        $interval = DateInterval::createFromDateString('20 minutes');

        $begin = new DateTime($this->shift_start_time);
        $end = new DateTime($this->shift_end_time);
        
        // DatePeriod won't include the final period by default, so increment the end-time by our interval
        // $end->add($interval);

        // Convert into array to make it easier to work with two elements at the same time
        $periods = iterator_to_array(new DatePeriod($begin, $interval, $end));

        // $start = array_shift($periods);

        $slots = [];
        foreach ($periods as $time) {
            $slots[] = $time->format(config('appGlobals.time_format'));
        }

        return $slots;
    }
}
