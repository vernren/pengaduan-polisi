<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // === PETUGAS ===
        User::create([
            'name' => 'Admin Polisi',
            'email' => 'admin@polisi.id',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'address' => 'Kantor Polisi Jakarta',
            'nik' => '3174012345678901',
            'role' => 'petugas',
        ]);

        // === MASYARAKAT ===
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '089876543210',
            'address' => 'Jl. Sudirman No. 45, Jakarta Selatan',
            'nik' => '3174011234567890',
            'role' => 'masyarakat',
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('');
        $this->command->info('📧 Login Petugas:');
        $this->command->info('   Email: admin@polisi.id');
        $this->command->info('   Password: password');
        $this->command->info('');
        $this->command->info('👤 Login Masyarakat:');
        $this->command->info('   Email: budi@gmail.com');
        $this->command->info('   Password: password');
    }
}
