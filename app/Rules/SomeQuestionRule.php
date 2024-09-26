<?php

namespace App\Rules;

use App\Models\Question;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SomeQuestionRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->validateQuestion($value)) {
            $fail('A pergunta já existe');
        }
    }

    private function validateQuestion(string $question): bool
    {
        return Question::where('question', $question)->exists();
    }
}
