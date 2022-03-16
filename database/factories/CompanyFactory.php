<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
    	return [
            'title' => $this->faker->company,
            'description' => $this->faker->text,
            'phone' => $this->faker->phoneNumber,
            'user_id' => $this->faker->numberBetween(1, 10)
        ];
    }
}
