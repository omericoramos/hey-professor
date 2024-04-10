<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('should list all the questions', function () {
    //Arrange

    $user = User::factory()->create();
    auth()->login($user);
    // Vamos criar aqui algumas perguntas para podermos testar a listagem
    $questions = Question::factory()->count(5)->create();
    // actingAs($user);
    //Act
    // Chamamos a rota de listagem de perguntas
    $response = get(route('dashboard'));

    //Asert
    // Aqui fazemos a listagem das perguntas

    /** @var Question $q */
    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }
});
