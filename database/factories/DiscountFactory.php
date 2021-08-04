<?php

namespace Database\Factories;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ar_name' => 'عرض الـ ' . $this->faker->unique()->word(),
            'en_name' => $this->faker->unique()->word(),
            'type' => ['fixed', 'percentage'][rand(0, 1)],
            'amount' => $this->faker->randomFloat(2, 1, 50),
        ];
    }
}
