<?php

namespace Database\Factories;

use App\Models\RaysTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

class RaysTypesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RaysTypes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ar_name' => 'آشعة ' . $this->faker->unique()->word(),
            'en_name' => $this->faker->unique()->word() . ' Ray',
        ];
    }
}
