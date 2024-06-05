<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

it('should be able to update a question', function () {

    $user = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $question), [
        'question' => 'Update question?',
    ])->assertRedirect();

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

    ])->assertRedirect();
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

    ])->assertRedirect();

    // faz um refresh nos dados da pergunta
    $question->refresh();

    // faço o login com o usuário que não é o criador da pergunta
    actingAs($wrongUser);

    // acesso a rota de atualização da pergunta deve retornar 403 (proibido)
    put(route('question.update', $question), [
        'question' => 'Update question?',

    ])->assertForbidden();
});
