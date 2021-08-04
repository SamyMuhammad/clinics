<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorData extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'specialization'];

    public static function findByDoctorId($id)
    {
        return static::where('doctor_id', $id)->first();
    }
    
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
