<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <form class="max-w-sm mx-auto" action="{{ route('question.store') }}" method="POST">
                    @csrf
                    <label for="pergunta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pergunta</label>
                    <div class="mb-2">
                        <textarea id="pergunta" rows="4" name="question"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 
                        focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 
                        dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Faça sua pergunta"> {{ old('question') }}</textarea>
                    </div>
                    <div>
                        <button type="submit"
                            class="text-white bg-blue-700 border border-gray-300 focus:outline-none hover:bg-blue-800  
                            focus:ring-4 focus:ring-gray-200 font-normal rounded-lg text-sm px-5 py-2 me-2 mb-2 
                            dark:bg-blue-700 dark:text-white dark:border-blue-400 dark:hover:bg-blue-800 
                            dark:hover:border-blue-900 dark:focus:ring-gray-700">Salvar</button>
                    </div>
                    <div class="h-7">
                        @error('question')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
