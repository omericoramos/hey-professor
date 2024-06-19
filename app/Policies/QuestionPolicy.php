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

    public function update(User $user, Question $question): bool
    {
        // retorna o proprio draft da question pois ele já é um booleano
        return $question->draft && $question->createdBy()->is($user);
    }

    public function achive(User $user, Question $question): bool
    {
        // verifica se a questão foi criada pelo usuário
        // se sim, retorna true, se não,retorna false
        return $question->createdBy()->is($user);
    }

    public function destroy(User $user, Question $question): bool
    {
        // verifica se a questão foi criada pelo usuário
        // se sim, retorna true, se não,retorna false
        return $question->createdBy()->is($user);
    }
}
