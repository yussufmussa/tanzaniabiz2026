<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User Management
            'view.users',
            'create.users',
            'update.users',
            'delete.users',
            'manage.users',

            // Category Management
            'view.categories',
            'create.categories',
            'update.categories',
            'delete.categories',
            'manage.categories',

            // Post Categories
            'view.postcategories',
            'create.postcategories',
            'update.postcategories',
            'delete.postcategories',
            'manage.postcategories',

            // Role Management
            'view.roles',
            'create.roles',
            'update.roles',
            'delete.roles',
            'manage.roles',

            // Booking / Orders Management
            'view.orders',
            'create.orders',
            'update.orders',
            'delete.orders',
            'manage.orders',

            // Payment Management
            'view.payments',
            'create.payments',
            'update.payments',
            'delete.payments',
            'manage.payments',

            // Post Tags
            'view.tags',
            'create.tags',
            'update.tags',
            'delete.tags',
            'manage.tags',

            // Post Management
            'view.posts',
            'create.posts',
            'update.posts',
            'delete.posts',
            'manage.posts',
            'publish.posts',

            // Packages
            'view.packages',
            'create.packages',
            'update.packages',
            'delete.packages',
            'manage.packages',

            // Social medias
            'view.social_medias',
            'create.social_medias',
            'update.social_medias',
            'delete.social_medias',
            'manage.social_medias',

            // Cities
            'view.cities',
            'create.cities',
            'update.cities',
            'delete.cities',
            'manage.cities',

            // Jobs posted
            'view.jobs',
            'create.jobs',
            'update.jobs',
            'delete.jobs',
            'manage.jobs',

            // events posted
            'view.events',
            'create.events',
            'update.events',
            'delete.events',
            'manage.events',

            // Listings
            'view.business_listings',
            'create.business_listings',
            'update.business_listings',
            'delete.business_listings',
            'approve.business_listings',
            'manage.business_listings',

            // Settings
            'manage.general_settings',
            'view.login_history',
            'manage.seo',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $this->createRoles();
    }

    private function createRoles()
    {
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $manager = Role::firstOrCreate(['name' => 'manager']);
        $manager->givePermissionTo([
            'manage.users',
            'manage.orders',
            'manage.payments',
            'manage.posts',
            'manage.seo',
            'manage.postcategories',
            'manage.tags',
            'manage.packages',
            'manage.business_listings',
            'manage.general_settings',
            'view.login_history',
        ]);

        $business_owner = Role::firstOrCreate(['name' => 'business_owner']);
        $business_owner->givePermissionTo([
            'view.business_listings',
            'create.business_listings',
            'update.business_listings',
            'delete.business_listings',
        ]);

        $editor = Role::firstOrCreate(['name' => 'editor']);
        $editor->givePermissionTo([
            'manage.posts',
        ]);

        $writer = Role::firstOrCreate(['name' => 'writer']);
        $writer->givePermissionTo([
            'view.posts',
            'create.posts',
            'update.posts',
            'delete.posts',
            'manage.posts',
        ]);
    }
}
