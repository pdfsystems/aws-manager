<?php

namespace Database\Factories;

use App\Models\Instance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class InstanceFactory extends Factory
{
    protected $model = Instance::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'architecture' => $this->faker->word(),
            'state' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
