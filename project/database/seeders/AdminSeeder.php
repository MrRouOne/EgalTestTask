<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::query()->where('is_admin', '=', true)->exists()) {
            User::factory()->create(
                [
                'first_name' => "admin",
                'last_name' => "admin",
                'email' => "admin@gmail.com",
                'password' => 'admin',
                'is_admin' => true,
                ]
            );
        }

    }
}
