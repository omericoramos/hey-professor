<?php

// deve ser capaz de criar uma nova pergunta com mais de 255 caracteres

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

it('should be able to create a new question bigger than 255 caracteres', function () {
    // Arrange :: preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act     :: agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 260).'?',
    ]);

    // Assert  :: verificar
    $request->assertRedirect(route('dashboard')); // redireciona para a dashboard
    assertDatabaseCount('questions', 1); // verifica se tem ao menos um registro da tabela do banco

    assertDatabaseHas('questions', [
        'question' => str_repeat('*', 260).'?',
    ]); // verifica se existe uma pergunta com 260 caracteres e o ponto de interrogação
});

// devo verificar se termina com ponto de interrogação ?
it('should check if ends with question mark?', function () {
});

// deve ter pelo menos 10 caracteres
it('should have at least 10 characteres', function () {
});
