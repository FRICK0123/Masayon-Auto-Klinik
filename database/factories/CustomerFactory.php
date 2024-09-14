<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fullname' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'username' => $this->faker->userName,
            'password' => Hash::make('password'), // default password
            'profile_img' => 'default_user.png', // You can change this according to your logic
            'email_verified_at' => now(), // Set this to `now()` for verified users
            'verification_token' => Str::random(40), // Generate a random verification token
            'isVerified' => true,
            'usertype' => "customer",
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
