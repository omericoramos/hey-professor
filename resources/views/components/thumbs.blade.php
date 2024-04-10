@props(['question'])

<div class="flex justify-between">

    <x-form :action="route('question.like', $question)">
        <button class="text-yellow-500 flex items-start space-x-1">
            <x-icons.thumbs-up class=" w-6 h-6 hover:text-yellow-300 cursor-pointer"></x-icons>
                <span class=" relative bottom-1">{{ $question->votes_sum_like ?: 0 }}</span>
        </button>

    </x-form>

    <x-form :action="route('question.unlike', $question)">
        <button class="text-rose-600 flex items-start space-x-1 align-middle">
            <x-icons.thumbs-down class="w-6 h-6  hover:text-rose-400 cursor-pointer"></x-icons>
                <span class=" relative bottom-1">{{ $question->votes_sum_unlike ?: 0 }}</span>
        </button>

    </x-form>
</div>
