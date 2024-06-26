<?php

// deve ser capaz de abrir uma pergunta para editar

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('should be able to opne a question to edit', function () {

    // primeiro eu crio o usuário
    $user = User::factory()->create();

    // depois eu crio a pergunta
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    // e eu faço o login com o usuário
    actingAs($user);

    // então eu acesso a rota de edição da pergunta
    get(route('question.edit', $question))->assertSuccessful();

});

// deve retornar uma pagina de edição de pergunta (edit.blade.php)
it('should return a view', function () {

    // primeiro eu crio o usuário
    $user = User::factory()->create();

    // depois eu crio a pergunta
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    // e eu faço o login com o usuário
    actingAs($user);

    // então eu acesso a rota de edição da pergunta
    get(route('question.edit', $question))->assertViewIs('question.edit');

});

// certficar de que apenas perguntas com status de rascunho possam ser editadas
it('should make sure that only question with status draft can be edited', function () {

    // primeiro eu crio o usuário
    $user = User::factory()->create();

    // crio a pergunta com draft true e outr com draft false (draft quer dizer rascunho)
    $questionNotDraft = Question::factory()->for($user, 'createdBy')->create(['draft' => false]);
    $questionDraft = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    // e eu faço o login com o usuário
    actingAs($user);

    // então eu acesso a rota de edição da pergunta deve retornar 403 (proibido)
    get(route('question.edit', $questionNotDraft))->assertForbidden();

    // então eu acesso a rota de edição da pergunta deve retornar 200 (sucesso)
    get(route('question.edit', $questionDraft))->assertSuccessful();

});

// certificar de que apenas a pessoa que criou a pergunta pode editá-la
it('should make sure only the person who created the question can edit it', function () {

    // primeiro eu crio o usuário
    $user = User::factory()->create();

    // crio um usuário que não é o criador da pergunta
    $wrongUser = User::factory()->create();

    // crio a pergunta com draft true com o usuário $user
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    // e eu faço o login com o usuário
    actingAs($user);

    // então eu acesso a rota de edição da pergunta deve retornar 200 (sucesso)
    get(route('question.edit', $question))->assertSuccessful();

    // faz um refresh nos dados da pergunta
    $question->refresh();

    // faço o login com o usuário que não é o criador da pergunta
    actingAs($wrongUser);

    // acesso a rota de edição da pergunta deve retornar 403 (proibido)
    get(route('question.edit', $question))->assertForbidden();

});
