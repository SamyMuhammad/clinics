<?php

namespace App\Models;

use App\Helpers\CommonMethods;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory, CommonMethods;

    protected $fillable = [
        'ar_name',
        'en_name',
        'phone',
        'email',
        'city',
        'address',
    ];

    /**
     * Get all of the patients for the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
