<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
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
            
            <div class="max-w-4xl mx-auto">
                <h1 class="dark:text-slate-500 uppercase text-xl font-semibold my-6">Lista de perguntas</h1>
                <x-questionsList :questions="$questions"/>
            </div>
        </div>
    </div>
</x-app-layout>
