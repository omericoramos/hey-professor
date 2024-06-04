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
    $question = Question::factory()->for($user, 'createdBy')->create();

    // e eu faço o login com o usuário
    actingAs($user);

    // então eu acesso a rota de edição da pergunta
    get(route('question.edit', $question))->assertSuccessful();

});
