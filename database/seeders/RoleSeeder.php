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
        
        // Créer les permissions
        $permissions = [
            'manage-users',
            'manage-courses',
            'manage-payments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Créer les rôles
        $roles = ['admin', 'formateur', 'apprenant'];
        
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
        
        // Créer un admin par défaut
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@opti-learning.com'],
            [
                'password' => bcrypt('Admin@123'),
                'first_name' => 'Admin',
                'last_name' => 'OPTI',
                'phone' => '+22900000000',
                'gender' => 'male',
                'birth_date' => '1990-01-01',
                'birth_place' => 'Système',
                'is_active' => true,
                'role' => 'admin',
                'is_super_admin' => true,
            ]
        );
        
        if (!$admin->is_super_admin) {
            $admin->update(['is_super_admin' => true]);
        }
        
        // Spatie role assignment
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}