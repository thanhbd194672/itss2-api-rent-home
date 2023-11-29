<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::lower(Str::ulid()->toBase32()),
            'username' => fake()->userName,
            'name' => fake()->name(),
            'school_name' => 'hust',
            'student_id' => '2019' . fake()->randomDigit() .fake()->randomDigit().fake()->randomDigit().fake()->randomDigit(),
            'password' => static::$password ??= Hash::make('132456'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
//    public function unverified(): static
//    {
//        return $this->state(fn (array $attributes) => [
//            'email_verified_at' => null,
//        ]);
//    }
}
