<?php

use App\Models\Question;

use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertSoftDeleted;

it('should prune recods deleted more than 1 month', function () {

    $question = Question::factory()->create(['deleted_at' => now()->subMonth(2)]); // cria a pergunta com deleted_at preenchido com a data de dois meses antes

    assertSoftDeleted('questions', ['id' => $question->id]); // garante que a pergunta esta deletada

    artisan('model:prune'); // roda o comando de delete definitivamente as perguntas com soft delete com a data com mais de um mês

    assertDatabaseMissing('questions', ['id' => $question->id]); // assegfura que a pergunta foi realmente deletada
});
