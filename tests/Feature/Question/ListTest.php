<?php

use App\Models\Question;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

it('should  paginate the listing result', function () {

    $user = User::factory()->create();

    // Vamos criar aqui algumas perguntas para podermos testar a paginação
    $questions = Question::factory()->count(20)->create();
    actingAs($user);

    // Chamamos a rota de listagem de perguntas
    $response = get(route('dashboard'))
        ->assertViewHas('questions', fn (LengthAwarePaginator $paginator) => $paginator->total() === 20);
});

// deve ordenar por like e unlike, a pergunta com mais like deve estar no topo, a pergunta com mais unlikes deve estar na parte inferior
it('should  order by  like and unlike, most liked question should be at the top, most unliked question shoul be in the bottom', function () {

    $user = User::factory()->create();
    $secondUser = User::factory()->create();

    Question::factory()->count(7)->create();

    $mostLikedQuestion = Question::find(3);
    $mostUnlikedQuestion = Question::find(1);

    $user->like($mostLikedQuestion);
    $secondUser->unlike($mostUnlikedQuestion);

    actingAs($user);

    // Chamamos a rota de listagem de perguntas
    $response = get(route('dashboard'))
        ->assertViewHas('questions', function (LengthAwarePaginator $paginator) {
            expect($paginator)->first()->id->toBe(3)
                ->and($paginator)->last()->id->toBe(1);

            return true;
        });
});
