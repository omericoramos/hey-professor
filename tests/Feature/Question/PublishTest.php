<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

// // deveria poder publicar uma pergunta
it('should be able to publish a question', function () {

    // cria um usuário
    $user = User::factory()->create();

    // faz login com o usuário
    actingAs($user);

    // cria uma pergunta em rascunho
    $question = Question::factory()
        ->for(user(), 'createdBy')
        ->create(['draft' => true]);

    // publica a pergunta
    put(route('questions.publish', $question))
        ->assertRedirect();

    // faz um refresh nos dados da pergunta
    $question->refresh();

    // espera que a pergunta seja publicada com sucesso
    expect($question)->draft->toBeFalse();
});

// deve certificar-se de que apenas a pessoa que criou a pergunta pode publicá-la
it('should make sure that only the person who has created the question can publish the question can publish it', function () {

    // cria um usuário certo
    $rightUser = User::factory()->create();

    // cria um usuário errado
    $wrongUser = User::factory()->create();

    // cria uma pergunta em rascunho
    $question = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    // faz login com o usuário errado
    actingAs($wrongUser);

    // tenta publicar a pergunta
    put(route('questions.publish', $question))
        ->assertForbidden(); // espera um erro 403 forbidden

    // faz um refresh nos dados da pergunta
    $question->refresh();

    actingAs($rightUser);

    // // tenta publicar a pergunta
    put(route('questions.publish', $question))
        ->assertRedirect();

    // faz um refresh nos dados da pergunta
    $question->refresh();

    // espera que a pergunta seja publicada com sucesso
    expect($question)->draft->toBeFalse();
});
