<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar pergunta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <x-form post :action="route('question.update', $question)" put>
                    <x-textarea name="question" label="Qual a sua pergunta?" value="{{$question->question}}" />
                    <x-btn.primery-button>
                        Atualizar a pergunta
                    </x-btn.primery-button>
                </x-form>
            </div>
        </div>
    </div>
</x-app-layout>
