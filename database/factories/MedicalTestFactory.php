<?php

namespace Database\Factories;

use App\Models\MedicalTest;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicalTestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MedicalTest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ar_name' => 'اختبار ' . $this->faker->unique()->word(),
            'en_name' => $this->faker->unique()->word() . ' Test',
        ];
    }
}
