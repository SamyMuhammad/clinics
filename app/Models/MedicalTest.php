<?php

namespace App\Models;

use App\Helpers\CommonMethods;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalTest extends Model
{
    use HasFactory, CommonMethods;

    protected $fillable = [
        'ar_name',
        'en_name',
    ];
}
