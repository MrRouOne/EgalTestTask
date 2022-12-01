<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::query()->where('email', '=', "user@gmail.com")->exists()) {
            User::factory()->create([
                'first_name' => "user",
                'last_name' => "user",
                'email' => "user@gmail.com",
                'password' => 'user',
                'is_admin' => false,
            ]);
        }

    }
}
