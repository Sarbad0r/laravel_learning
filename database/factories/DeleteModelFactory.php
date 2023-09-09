<?php

namespace Database\Factories;

use App\Models\DeleteModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DeleteModelFactory extends Factory
{

    //while you creating model and factory
    //do not forget to create same name model and factory
    //for example: Model's name is "DeleteModel"
    //factory name should be "DeleteModelFactory"

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    protected $model = DeleteModel::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,  //getting random user
            "string" => fake()->text(),
            'integer' => fake()->numberBetween(1, 1000),
            'boolean' => fake()->boolean(),
            'double' => fake()->randomFloat(),
            'dateTime' => fake()->dateTime(),
            'date' => fake()->date(),
            'time' => fake()->time()
        ];
    }
}
