@props(['label', 'name'])

<label for="pergunta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>

<div class="mb-2 w-full">
    <textarea id="{{ $name }}" rows="6" name="{{ $name }}"
        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 
                        focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 
                        dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 
                        dark:focus:border-blue-500"
        placeholder="Faça sua pergunta"> {{ old("$name") }}</textarea>
    <x-error :name="$name" />
</div>
