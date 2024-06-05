<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // criando um novo usuário
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // adicionando 10 questões
        Question::factory()->count(80)->create();
    }
}
