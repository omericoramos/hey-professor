<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\delete;

// // deveria poder deletar uma pergunta
it('should be able to destroy a question', function () {

    // cria um usuário
    $user = User::factory()->create();

    // faz login com o usuário
    actingAs($user);

    // cria uma pergunta em rascunho
    $question = Question::factory()
        ->for(user(), 'createdBy')
        ->create(['draft' => true]);
    // deleta a pergunta
    delete(route('question.destroy', $question))
        ->assertRedirect();

    assertDatabaseMissing('questions', [
        'id' => $question->id,
    ]);
});

// deve certificar-se de que apenas a pessoa que criou a pergunta pode publicá-la
it('should make sure that only the person who has created the question can destroy the question can destroy it', function () {

    // cria um usuário certo
    $rightUser = User::factory()->create();

    // cria um usuário errado
    $wrongUser = User::factory()->create();

    // cria uma pergunta em rascunho
    $question = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    // faz login com o usuário errado
    actingAs($wrongUser);

    // tenta destroy a pergunta
    delete(route('question.destroy', $question))
        ->assertForbidden(); // espera um erro 403 forbidden

    // faz um refresh nos dados da pergunta
    $question->refresh();

    actingAs($rightUser);

    // // tenta destroy a pergunta
    delete(route('question.destroy', $question))
        ->assertRedirect();
});
