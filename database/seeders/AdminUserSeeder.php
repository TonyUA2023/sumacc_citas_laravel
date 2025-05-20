<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        AdminUser::updateOrCreate(
            ['email' => 'admin@tusitio.com'],
            ['password_hash' => Hash::make('admin1234')]
        );
    }
}
