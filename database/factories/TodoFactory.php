<?php

namespace Database\Factories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Todo::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'in progress', 'completed']),
            'details' => $this->faker->paragraph()
        ];
    }
}
