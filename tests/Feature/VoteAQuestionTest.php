<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

it('shuld be able to like a question', function () {

    // cria um usuario
    $user = User::factory()->create();

    // cria uma pergunta
    $question = Question::factory()->create();

    // Faz login com o usuario criado
    actingAs($user);

    post(route('question.like', $question))
        ->assertRedirect();

    // Verifica se o voto foi registrado no banco de dados para passar no teste
    assertDatabaseHas('votes', [
        'user_id' => $user->id,
        'question_id' => $question->id,
        'like' => 1,
        'unlike' => 0,
    ]);
});

it('shuld not be able to like more than 1 time', function () {

    // cria um usuario
    $user = User::factory()->create();

    // cria uma pergunta
    $question = Question::factory()->create();

    // Faz login com o usuario criado
    actingAs($user);

    post(route('question.like', $question));
    post(route('question.like', $question));
    post(route('question.like', $question));
    post(route('question.like', $question));

    expect($user->votes()->where('question_id', '=', $question->id)->get())->toHaveCount(1);
});
