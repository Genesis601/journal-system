<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@journalspace.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );

        $admin->assignRole('super_admin');

        $editor = User::firstOrCreate(
            ['email' => 'editor@journalspace.com'],
            [
                'name'     => 'Journal Editor',
                'password' => Hash::make('password'),
            ]
        );

        $editor->assignRole('editor');

        $author = User::firstOrCreate(
            ['email' => 'author@journalspace.com'],
            [
                'name'     => 'Test Author',
                'password' => Hash::make('password'),
            ]
        );

        $author->assignRole('author');

        $this->command->info('Test users created successfully.');
        $this->command->info('Admin:  admin@journalspace.com / password');
        $this->command->info('Editor: editor@journalspace.com / password');
        $this->command->info('Author: author@journalspace.com / password');
    }
}