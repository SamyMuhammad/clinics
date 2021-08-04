<?php

namespace App\Models;

use App\Helpers\CommonMethods;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory, CommonMethods;

    protected $fillable = [
        'ar_name',
        'en_name',
        'type',
        'amount',
    ];

    /**
     * Adding '%' to the 'amount' if the type is 'percentage'.
     */
    public function getRenderedAmountAttribute()
    {
        if ($this->type == 'percentage') {
            return $this->amount.'%';
        }
        return $this->amount;
    }
}
