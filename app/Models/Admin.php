<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
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
        'address',
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
        return config('appGlobals.uploads_path') ."/admins/images/". $this->photo;
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
        return Storage::disk('uploads')->delete('/admins/images/'. $this->photo);
    }
}
