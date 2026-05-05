<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un admin
        User::create([
            'name' => 'Admin PEBCO',
            'email' => 'admin@pebco.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        // Créer des agents
        User::create([
            'name' => 'Agent Test',
            'email' => 'agent@pebco.com',
            'role' => 'agent',
            'password' => Hash::make('agent123'),
        ]);

        User::create([
            'name' => 'Agent Marie',
            'email' => 'marie@pebco.com',
            'role' => 'agent',
            'password' => Hash::make('agent123'),
        ]);

        // Créer des clients
        User::create([
            'name' => 'Client Test',
            'email' => 'client@pebco.com',
            'role' => 'user',
            'password' => Hash::make('client123'),
        ]);

        User::create([
            'name' => 'Jean Dupont',
            'email' => 'jean@pebco.com',
            'role' => 'user',
            'password' => Hash::make('client123'),
        ]);

        $this->command->info('Utilisateurs créés avec succès !');
        $this->command->info('Admin: admin@pebco.com / admin123');
        $this->command->info('Agent: agent@pebco.com / agent123');
        $this->command->info('Client: client@pebco.com / client123');
    }
}
