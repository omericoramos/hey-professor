<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Rules\EndWithQuestionMarkRule;
use App\Rules\SomeQuestionRule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('question.index', [
            'questions' => user()->questions()->get(),
            'archiveQuestions' => user()->questions()->onlyTrashed()->get(),
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
                    new SomeQuestionRule(),
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

    public function edit(Question $question): View
    {
        $this->authorize('update', $question);

        return view('question.edit', compact('question'));
    }

    public function update(Question $question): RedirectResponse
    {
        $this->authorize('update', $question);

        request()->validate(
            [
                'question' => [
                    'required',
                    'min:10',
                    new EndWithQuestionMarkRule(),
                ],
            ]
        );

        $question->update([
            'question' => request()->question,
        ]);

        return to_route('question.index');
    }

    public function archive(Question $question): RedirectResponse
    {
        $this->authorize('achive', $question);
        $question->delete(); // softDelete

        return back();
    }

    public function restore(int $id): RedirectResponse
    {
        $question = Question::withTrashed()->find($id);

        $this->authorize('restore', $question);
        $question->restore();

        return back();
    }

    public function destroy(Question $question): RedirectResponse
    {
        // checa se o usuário tem permissão para deletar a pergunta (o arquivo de autorização esta em app/Policies/QuestionPolicy.php)
        $this->authorize('destroy', $question);
        $question->forceDelete();

        return back();
    }
}
