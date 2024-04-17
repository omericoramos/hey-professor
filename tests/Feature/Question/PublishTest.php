<?php

// deveria poder publicar uma pergunta

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

it('should be able to publish a question', function () {

    // cria um usuário
    $user = User::factory()->create();

    // cria uma pergunta em rascunho
    $question = Question::factory()->create(['draft' => true]);

    // faz login com o usuário
    actingAs($user);

    // publica a pergunta

    put(route('questions.publish', $question))
        ->assertRedirect();

    // faz um refresh nos dados da pergunta
    $question->refresh();

    // espera que a pergunta seja publicada com sucesso
    expect($question)->draft->toBeFalse();
});
