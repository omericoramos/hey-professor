@props(['text'])

<div>
    <button type="submit"
        class="text-white bg-blue-700 border border-gray-300 focus:outline-none hover:bg-blue-800  
                            focus:ring-4 focus:ring-gray-200 font-normal rounded-lg text-sm px-5 py-2 me-2 mb-2 
                            dark:bg-blue-700 dark:text-white dark:border-blue-400 dark:hover:bg-blue-800 
                            dark:hover:border-blue-900 dark:focus:ring-gray-700">{{ $text }}</button>
</div>
