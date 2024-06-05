<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\put;

it('should be able to update a question', function () {

    $user = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $question), [
        'question' => 'Update question?',
    ])->assertRedirect(route('question.index'));

    $question->refresh();

    expect($question->question)->toBe('Update question?');
});

// certficar de que apenas perguntas com status de rascunho possam ser atualizadas
it('ensure that only questions with draft status can be updated', function () {

    // primeiro eu crio o usuário
    $user = User::factory()->create();

    // crio a pergunta com draft true e outr com draft false (draft quer dizer rascunho)
    $questionNotDraft = Question::factory()->for($user, 'createdBy')->create(['draft' => false]);
    $questionDraft = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    // e eu faço o login com o usuário
    actingAs($user);

    // então eu acesso a rota de atualização da pergunta deve retornar 403 (proibido)
    put(route('question.update', $questionNotDraft), [
        'question' => 'Update question?',

    ])->assertForbidden();

    // então eu acesso a rota de atualização da pergunta deve atualizar a perguntar e redirecionar para a rota de edição da pergunta
    put(route('question.update', $questionDraft), [
        'question' => 'Update question?',

    ])->assertRedirect(route('question.index'));
});

// certificar de que apenas a pessoa que criou a pergunta pode atualizá-la
it('should make sure only the person who created the question can update it', function () {

    // primeiro eu crio o usuário
    $user = User::factory()->create();

    // crio um usuário que não é o criador da pergunta
    $wrongUser = User::factory()->create();

    // crio a pergunta com draft true com o usuário $user
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    // e eu faço o login com o usuário
    actingAs($user);

    // então eu acesso a rota de atualização da pergunta deve atualizar a perguntar e redirecionar para a rota de edição da pergunta
    put(route('question.update', $question), [
        'question' => 'Update question?',

    ])->assertRedirect(route('question.index'));

    // faz um refresh nos dados da pergunta
    $question->refresh();

    // faço o login com o usuário que não é o criador da pergunta
    actingAs($wrongUser);

    // acesso a rota de atualização da pergunta deve retornar 403 (proibido)
    put(route('question.update', $question), [
        'question' => 'Update question?',

    ])->assertForbidden();
});

// deve ser capaz de atualizar uma pergunta com mais de 255 caracteres
it('should be able to updated a question bigger than 255 caracteres', function () {

    // Arrange :: preparar
    $user = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    actingAs($user);

    // Act     :: agir
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 260).'?',
    ]);

    // Assert  :: verificar

    $request->assertRedirect(route('question.index')); // faz o redirecionamento para a rota de perguntas

    assertDatabaseCount('questions', 1); // verifica se tem ao menos um registro da tabela do banco

    assertDatabaseHas('questions', [
        'question' => str_repeat('*', 260).'?',
    ]); // verifica se existe uma pergunta com 260 caracteres e o ponto de interrogação

});

// devo verificar se termina com ponto de interrogação (?)
it('should check if ends with question mark?', function () {
    // Arrange:: preparar
    $user = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    actingAs($user);

    // Act:: agir

    // tenta atualizar uma pergunta com 10 caracteres sem o ponto de interrogação para gerar o erro
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 10),
    ]);

    // Assert:: verificar

    // verifica se o erro passado é de uma pergunta sem interrogação
    // resposta: Tem certeza de que isso é uma pergunta? Falta um ponto de interrogação no final
    $request->assertSessionHasErrors(
        ['question' => 'Are you sure that is a questions? It is missing to question mark in the end.']
    );

    assertDatabaseHas('questions', [
        'question' => $question->question,
    ]);
});

// deve ter pelo menos 10 caracteres
it('should have at least 10 characteres', function () {

    // Arrange:: preparar
    $user = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    actingAs($user);

    // Act:: agir

    // tenta atualizar uma pergunta com menos de 10 caracteres para gerar o erro
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 8).'?',
    ]);

    // Assert:: verificar

    // verifica se o erro passado é o erro de minimo e que é uma string para poder passar no teste
    $request->assertSessionHasErrors(
        ['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]
    );

    assertDatabaseHas('questions', [
        'question' => $question->question,
    ]);
});
