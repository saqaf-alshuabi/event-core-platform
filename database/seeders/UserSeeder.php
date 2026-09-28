<?php

namespace Database\Seeders;

use App\Models\Attendee;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->admin()
            ->create([
                'name' => 'Admin',
                'email' => 'admin@eventcore.test',
            ]);

        User::factory(10)
            ->has(Attendee::factory()->count(1))
            ->create();
    }
}
