<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalTestRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'medical_test_id',
        'tests_responsible_id',
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

    public function medical_test()
    {
        return $this->belongsTo(MedicalTest::class, 'medical_test_id');
    }

    public function tests_responsible()
    {
        return $this->belongsTo(User::class, 'tests_responsible_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
