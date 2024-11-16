<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'admin_logo' => 'Masayon Auto Klinik Logo.png',
            'email' => 'Makdiagnostic01@gmail.com',
            'phone_number' => '9171462724',
            'username' => 'Admin',
            'password' => bcrypt('admin123'),
            'usertype' => 'admin',
        ];
    }
}
