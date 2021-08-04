<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ar_name' => 'شركة ' . $this->faker->unique()->word(),
            // 'en_name' => $this->faker->unique()->word(),
            'en_name' => $this->faker->unique()->company(),
            'phone' => '014123' . $this->faker->unique()->randomNumber(5, true),
            'email' => $this->faker->unique()->email,
            'city' => $this->faker->city,
            'address' => $this->faker->address,
        ];
    }
}
