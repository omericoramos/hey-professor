<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('should be able to search a question by text', function () {

    $user = User::factory()->create();

    Question::factory()->create(['question' => 'My question is?']);

    actingAs($user);

    $respnse = get(route('dashboard'), [
        'search' => 'question',
    ]);

    $respnse->assertSee('My question is?');
});
