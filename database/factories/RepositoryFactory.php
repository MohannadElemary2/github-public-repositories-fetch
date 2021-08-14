<?php

namespace Database\Factories;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RepositoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Repository::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'external_id' => $this->faker->numberBetween(),
            'name' => $this->faker->name(),
            'full_name' => $this->faker->name(),
            'language' => $this->faker->text(),
            'owner_name' => $this->faker->name(),
            'owner_image' => $this->faker->imageUrl(),
            'stars' => $this->faker->numberBetween(),
            'created' => $this->faker->date(),
        ];
    }
}
