<?php

namespace App\Http\Controllers;

use App\Rules\EndWithQuestionMarkRule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('question.index', [
            'questions' => user()->questions()->get(),
        ]);
    }

    public function store(): RedirectResponse
    {
        request()->validate(
            [
                'question' => [
                    'required',
                    'min:10',
                    new EndWithQuestionMarkRule(),
                ],
            ]
        );

        // faz o usuário atual criar uma nova pergunta no banco de dados
        user()->questions()->create([
            'question' => request()->question,
            'draft' => true,
        ]);

        return back();
    }
}
