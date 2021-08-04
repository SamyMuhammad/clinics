<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'floor_number',
        'beds_count',
    ];

    public function getResidentsCountAttribute()
    {
        return $this->patients->count();
    }

    public function getIsFullAttribute()
    {
        return $this->beds_count == $this->residentsCount ? true : false;
    }

    /**
     * Get only not full rooms.
     */
    public function scopeNotFull($query)
    {
        return $query->has('patients', '<', \DB::raw('beds_count'));
        // return $query->whereRaw('(select count(*) from `patients` where `rooms`.`id` = `patients`.`room_id`) < `rooms`.`beds_count`');
        // return $query->withCount('patients')->having('patients_count', '<', \DB::raw('beds_count'));
    }

    /**
     * Get all of the patients for the Room
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
