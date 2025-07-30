<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);

        $adminUser = User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' =>   Hash::make('password'),
            'role' => 'admin', 
        ]);

        $adminUser->assignRole('admin');
    }
}
