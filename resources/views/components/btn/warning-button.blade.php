@props(['tooltip', 'tooltipTitle'])
<div>
    <button type="submit" data-tooltip-target="tooltip-{{ $tooltip }}"
        class="text-white bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 hover:bg-gradient-to-br 
        focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:focus:ring-yellow-800 shadow-lg shadow-yellow-500/50 
        dark:shadow-lg dark:shadow-yellow-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
        {{ $slot }}
    </button>

    <div @if ($tooltip) id="tooltip-{{ $tooltip }}" @endif  role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 
        bg-yellow-500 rounded-lg shadow-sm opacity-0 tooltip dark:bg-yellow-500">
        {{ $tooltipTitle }}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</div>