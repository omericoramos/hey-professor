<?php

// deve ser capaz de criar uma nova pergunta com mais de 255 caracteres

use App\Models\Question;
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

    $request->assertRedirect(); // faz o redirecionamento para a rota de perguntas

    assertDatabaseCount('questions', 1); // verifica se tem ao menos um registro da tabela do banco

    assertDatabaseHas('questions', [
        'question' => str_repeat('*', 260).'?',
    ]); // verifica se existe uma pergunta com 260 caracteres e o ponto de interrogação

});

// devo verificar se termina com ponto de interrogação ?
it('should check if ends with question mark?', function () {
    // Arrange:: preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act:: agir

    // cria uma pergunta com 10 caracteres sem o ponto de interrogação para gerar o erro
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 10),
    ]);

    // Assert:: verificar

    // verifica se o erro passado é uma pergunta sem interrogação
    // resposta: Tem certeza de que isso é uma pergunta? Falta um ponto de interrogação no final
    $request->assertSessionHasErrors(
        ['question' => 'Are you sure that is a questions? It is missing to question mark in the end.']
    );

    // verifica se tem zero registro da tabela do banco para passar no teste
    assertDatabaseCount('questions', 0);
});

// deve ter pelo menos 10 caracteres
it('should have at least 10 characteres', function () {

    // Arrange:: preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act:: agir

    // cria uma pergunta com menos de 10 caracteres para gerar o erro
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 8).'?',
    ]);

    // Assert:: verificar

    // verifica se o erro passado é o erro de minimo e que é uma string para poder passar no teste
    $request->assertSessionHasErrors(
        ['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]
    );

    // verifica se tem zero registro da tabela do banco para passar no teste
    assertDatabaseCount('questions', 0);
});

// devo criar todas as perguntas como rascunho
it('sholud create as draft all the time', function () {

    // Arrange:: preparar
    $user = User::factory()->create();

    actingAs($user);

    // Act     :: agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 260).'?',
    ]);

    assertDatabaseHas('questions', [

        'question' => str_repeat('*', 260).'?', // verifica se existe uma pergunta com 260 caracteres e o ponto de interrogação

        'draft' => true, // verifica se a pergunta é um rascunho
    ]);
});

// apenas usuários autenticados podem criar uma nova pergunta
it('only authenticated users  can create a new question', function () {

    // cria uma pergunta com menos de 10 caracteres para gerar o erro
    post(route('question.store'), [
        'question' => str_repeat('*', 8).'?',
    ])->assertRedirect(route('login')); // redireciona para a tela de login);

});

it('question should be unique', function () {
    // Arrange:: preparar
    $user = User::factory()->create();

    actingAs($user);

    Question::factory()->create(['question' => 'Alguma pergunta?']);

    post(route('question.store'), [
        'question' => 'Alguma pergunta?',
    ])->assertSessionHasErrors(['question' => 'A pergunta já existe']);
});
