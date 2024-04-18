<?php

// deve ser capaz de listar todas as perguntas criadas por mim

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('should be able to list all questions created by me', function () {

    // criando os dois usuários
    $wrongUser = User::factory()->create();

    $user = User::factory()->create();

    // criando as perguntas para os dois usuários
    $wrongQuestion = Question::factory()->for($wrongUser, 'createdBy')->count(10)->create();

    $questions = Question::factory()->for($user, 'createdBy')->count(10)->create();

    // logando com o usuário correto
    actingAs($user);

    $response = get(route('question.index'));

    // listando todas as perguntas criadas pelo usuário correto
    foreach ($questions as $question) {

        $response->assertSee($question->question);
    }

    // não listando todas as perguntas criadas pelo usuário errado
    foreach ($wrongQuestion as $question) {

        $response->assertDontSee($question->question);
    }

});
