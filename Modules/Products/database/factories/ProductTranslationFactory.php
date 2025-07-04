<?php

namespace Modules\Products\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Products\App\Models\ProductTranslation;

class ProductTranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = ProductTranslation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'notes' => $this->faker->sentence,
            'locale' => 'en',
        ];
    }
} 