@props(['tooltip' => null,'tooltipTitle' => null])

<div>
    <button type="submit" data-tooltip-target="tooltip-{{ $tooltip }}"
        class="text-white bg-gradient-to-r from-green-500 via-green-600 to-green-700 hover:bg-gradient-to-br 
        focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 
        dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 ">
        {{ $slot }}
    </button>
    <div @if ($tooltip) id="tooltip-{{ $tooltip }}" @endif role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white 
        transition-opacity duration-300 bg-green-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-green-700">
        {{ $tooltipTitle }}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</div>