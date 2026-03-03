<?php

namespace Database\Factories;

use App\Models\TargetGroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TargetGroupFactory extends Factory
{
    protected $model = TargetGroup::class;

    public function definition(): array
    {
        return [
            'arn' => "arn:aws:elasticloadbalancing:us-east-1:{$this->faker->randomNumber(10)}:{$this->faker->randomAscii()}",
            'vpc' => "vpc-{$this->faker->randomAscii()}",
            'protocol' => $this->faker->word(),
            'port' => $this->faker->randomNumber(),
            'name' => $this->faker->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
