<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        AdminUser::create([
            'email' => 'admin@wayraplace.com',
            'password_hash' => Hash::make('Wayra2024@'),
        ]);

        echo "✅ Administrador creado exitosamente.\n";
    }
}