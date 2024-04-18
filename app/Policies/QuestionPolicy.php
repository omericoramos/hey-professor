<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;

class QuestionPolicy
{
    public function publish(User $user, Question $question): bool
    {
        // verifica se a questão foi criada pelo usuário
        // se sim, retorna true, se não,retorna false
        return $question->createdBy()->is($user);
    }
}
