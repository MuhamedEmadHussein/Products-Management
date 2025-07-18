<?php

namespace Modules\Products\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Products\App\Models\CategoryTranslation;

class CategoryTranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = CategoryTranslation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->sentence,
            'locale' => 'en',
        ];
    }
} 