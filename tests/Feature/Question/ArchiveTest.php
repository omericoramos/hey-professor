<?php

// deve ser capaz de arquivar uma pergunta

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\patch;

it('should be able to archive a question', function () {
    // cria um usuário
    $user = User::factory()->create();

    // faz login com o usuário
    actingAs($user);

    // cria uma pergunta em rascunho
    $question = Question::factory()
        ->for(user(), 'createdBy')
        ->create(['draft' => true]);

    // deleta a pergunta
    patch(route('question.archive', $question))
        ->assertRedirect();

    assertSoftDeleted('questions', [
        'id' => $question->id,
    ]);

    // Espera que o campo delete_at não esteja nulo
    expect($question)
        ->refresh()
        ->deleted_at
        ->not()->toBeNull();
});

// deve certificar-se de que apenas a pessoa que criou a pergunta pode archiva-la
it('should make sure that only the person who has created the question can destroy the question can archive it', function () {

    // cria um usuário certo
    $rightUser = User::factory()->create();

    // cria um usuário errado
    $wrongUser = User::factory()->create();

    // cria uma pergunta em rascunho
    $question = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    // faz login com o usuário errado
    actingAs($wrongUser);

    // tenta arquivar a pergunta
    patch(route('question.archive', $question))
        ->assertForbidden(); // espera um erro 403 forbidden

    // faz um refresh nos dados da pergunta
    $question->refresh();

    actingAs($rightUser);

    // tenta arquivar a pergunta
    patch(route('question.archive', $question))
        ->assertRedirect();
});
