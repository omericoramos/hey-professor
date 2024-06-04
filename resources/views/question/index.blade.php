<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Minhas perguntas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div>
                <x-form post :action="route('question.store')">
                    <x-textarea name="question" label="Qual a sua pergunta?" />
                    <x-btn.primery-button text="Salvar a pergunta" />
                </x-form>
            </div>

             {{-- Listagens de rascunho --}}
            <div class="max-w-5xl mx-auto">
                <h1 class="dark:text-slate-500 uppercase text-xl font-semibold my-6">Lista de rascunos</h1>
                <x-questions.questions-list :questions="$questions->where('draft', true)" :draft=true/>
            </div>
            
            {{-- Listagens de perguntas publicadas --}}
            <div class="max-w-5xl mx-auto">
                <h1 class="dark:text-slate-500 uppercase text-xl font-semibold my-10">Lista de perguntas</h1>
                <x-questions.questions-list :questions="$questions->where('draft', false)" :draft=false/>
            </div>
        </div>
    </div>
</x-app-layout>