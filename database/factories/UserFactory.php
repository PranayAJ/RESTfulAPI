<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
            'verified' => $verified = $this->faker->randomElement([User::VERIFIED_USER,User::UNVERIFIED_USER]),
            'verification_token' => $verified == User::VERIFIED_USER ? null : User::generateVerificationCode(),
            'admin' => $verified == User::VERIFIED_USER ? $this->faker->randomElement([User::ADMIN_USER, User::REGULAR_USER]) : User::REGULAR_USER,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
