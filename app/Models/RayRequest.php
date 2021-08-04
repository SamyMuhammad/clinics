<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RayRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'ray_type_id',
        'technician_id',
        'file_id',
    ];

    /* | Relationships methods (each instance from this model belongs to one) | */

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function ray_type()
    {
        return $this->belongsTo(RaysTypes::class, 'ray_type_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
