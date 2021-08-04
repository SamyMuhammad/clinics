<?php


namespace App\Helpers;

use Carbon\Carbon;

trait CheckDoctorsTimes
{
    /**
     * Make sure that end time is after start time.
     */
    public function isEndTimeAfterStartTime(array $times):bool
    {
        $timesChunks = array_chunk($times, 2);
        foreach ($timesChunks as $array){
            if (empty($array[0]) xor empty($array[1])) {
                return false;
            }else{
                $startTime = Carbon::parse($array[0]);
                $endTime = Carbon::parse($array[1]);
                if (!$startTime->isBefore($endTime)){
                    // dd($startTime, $endTime);
                    return false;
                }
            }
        }
        return true;
    }
}
