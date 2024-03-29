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
        </div>
    </div>
</x-app-layout>
