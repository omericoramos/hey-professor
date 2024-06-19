<?php

// deveria ser capaz de restaurar uma pergunta arquivada

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertNotSoftDeleted;
use function Pest\Laravel\patch;

it('should to be able to restore an arquived question', function () {
    // cria um usuário
    $user = User::factory()->create();

    // faz login com o usuário
    actingAs($user);

    // cria uma pergunta em rascunho
    $question = Question::factory()
        ->for(user(), 'createdBy')
        ->create([
            'draft' => true,
            'deleted_at' => null,
        ]);

    // restaura a pergunta
    patch(route('question.restore', $question->id))
        ->assertRedirect();

    assertNotSoftDeleted('questions', [
        'id' => $question->id,
    ]);

    // Espera que o campo delete_at não esteja nulo
    expect($question)
        ->refresh()
        ->deleted_at
        ->toBeNull();
});

// deve certificar-se de que apenas a pessoa que criou a pergunta pode restaura-la
it('should make sure that only the person who has created the question can destroy the question can restore it', function () {

    // cria um usuário certo
    $rightUser = User::factory()->create();

    // cria um usuário errado
    $wrongUser = User::factory()->create();

    // cria uma pergunta em rascunho
    $question = Question::factory()->create([
        'draft' => true,
        'created_by' => $rightUser->id,
        'deleted_at' => now(),
    ]);

    // faz login com o usuário errado
    actingAs($wrongUser);

    // tenta arquivar a pergunta
    patch(route('question.restore', $question))
        ->assertForbidden(); // espera um erro 403 forbidden

    // faz um refresh nos dados da pergunta
    $question->refresh();

    actingAs($rightUser);

    // tenta arquivar a pergunta
    patch(route('question.restore', $question))
        ->assertRedirect();
});
