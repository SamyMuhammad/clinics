<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'photo',
        'job',
        'address',
        'salary',
        'contract_period',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    /* protected $casts = [
    'email_verified_at' => 'datetime',
    ]; */

    /**
     * Scope a query to only include popular doctors.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDoctors($query)
    {
        return $query->where('job', 'doctor');
    }

    public function scopeTechnicians($query)
    {
        return $query->where('job', 'ray_technician');
    }

    public function scopeTestResposibles($query)
    {
        return $query->where('job', 'test_responsible');
    }

    /**
     * Get array of values for the enum fields.
     *
     * @param String $field
     * @return Array
     */
    public static function getEnumValues(String $field = '')
    {
        switch ($field) {
            case 'job':
                return ['doctor', 'user', 'ray_technician', 'test_responsible'];
                break;

            default:
                return [];
                break;
        }
    }

    /**
     * Get the path of the different types of files.
     *
     * @param string $type
     * @return string
     */
    public static function getPath(String $type)
    {
        if (in_array($type, ['images'])) {
            return config('appGlobals.uploads_path') . "/users/$type/";
        } else {
            throw new \Exception('The File Type You Passed To The Function getPath() Is Invalid.');
        }
    }

    /**
     * Get full path of user photo.
     *
     * @return string
     */
    public function getFullPhotoPathAttribute()
    {
        // Check if it's the default photo.
        if (strpos($this->photo, 'assets') === 0) {
            return $this->photo;
        }
        return static::getPath('images') . $this->photo;
    }

    /**
     * Delete the user photo from the uploads.
     */
    public function deletePhotoFromUploads()
    {
        // If its the default photo, don't delete it.
        if (strpos($this->photo, 'assets') === 0) {
            return true;
        }
        return Storage::disk('uploads')->delete('/users/images/' . $this->photo);
    }

    /**
     * Check if user is a doctor.
     *
     * @return boolean
     */
    public function isDoctor()
    {
        return $this->job === 'doctor';
    }

    /**
     * Check if user is a technician.
     *
     * @return boolean
     */
    public function isTechnician()
    {
        return $this->job === 'ray_technician';
    }

    /**
     * Check if user is a test resposible.
     *
     * @return boolean
     */
    public function isTestResponsible()
    {
        return $this->job === 'test_responsible';
    }

    # Doctors Relationships #
    public function clinics()
    {
        if ($this->job !== 'doctor') {
            throw new Exception("User is not a doctor.");
        }
        return $this->belongsToMany(Clinic::class, 'clinic_doctor', 'doctor_id', 'clinic_id')
            ->using(ClinicDoctor::class)
            ->withPivot('day_name', 'shift_start_time', 'shift_end_time')
            ->withTimestamps();
    }

    public function patients()
    {
        if ($this->job !== 'doctor') {
            throw new Exception("User is not a doctor.");
        }
        return $this->belongsToMany(Patient::class, 'doctor_patient', 'doctor_id', 'patient_id')->withTimestamps();
    }

    public function data()
    {
        return $this->hasOne(DoctorData::class, 'doctor_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'doctor_id');
    }
    # End Doctors Relationships #

    /**
     * Get the days that doesn't exist in doctors work times.
     */
    public function getDisabledDaysForDatePicker()
    {
        foreach ($this->clinics as $clinic) {
            $days[] = $clinic->pivot->day_name;
        }

        $disapledDays = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        if (!empty($days)) {
            $days = array_unique($days);
            foreach ($days as $value) {
                $key = array_search($value, $disapledDays);
                unset($disapledDays[$key]);
            }
        }
        // In case there one day off, I add a trivial element to avoid datepicker error when looking for ',' to seperate days.
        if (count($disapledDays) < 2) {
            $disapledDays[9999] = 'foo';
        }
        return implode(',', array_keys($disapledDays));
    }
}
