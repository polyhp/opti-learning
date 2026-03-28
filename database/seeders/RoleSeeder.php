<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Réinitialiser les rôles et permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Créer les rôles
        $roles = ['admin', 'formateur', 'apprenant'];
        
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
        
        // Créer un admin par défaut
        $admin = \App\Models\User::create([
            'email' => 'admin@opti-learning.com',
            'password' => bcrypt('Admin@123'),
            'first_name' => 'Admin',
            'last_name' => 'OPTI',
            'phone' => '+22900000000',
            'gender' => 'male',
            'birth_date' => '1990-01-01',
            'birth_place' => 'Système',
            'is_active' => true,
        ]);
        
        $admin->assignRole('admin');
    }
}