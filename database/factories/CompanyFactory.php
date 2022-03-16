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
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
