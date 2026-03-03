<?php

namespace Database\Factories;

use App\Models\Target;
use App\Models\TargetGroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TargetFactory extends Factory
{
    protected $model = Target::class;

    public function definition(): array
    {
        return [
            'instance' => $this->faker->word(),
            'state' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'target_group_id' => TargetGroup::factory(),
        ];
    }
}
