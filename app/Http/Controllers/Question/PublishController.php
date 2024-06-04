<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;

class PublishController extends Controller
{
    public function __invoke(Question $question): RedirectResponse
    {
        // checa se o usuário tem permissão para publicar a pergunta (o arquivo de autorização esta em app/Policies/QuestionPolicy.php)
        $this->authorize('publish', $question);

        $question->update([
            'draft' => false,
        ]);

        return back();
    }
}
