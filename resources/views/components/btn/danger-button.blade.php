@props(['tooltip', 'tooltipTitle'])
<div>
    <button type="submit" data-tooltip-target="tooltip-{{ $tooltip }}"
        class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br 
        focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 
        dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
        {{ $slot }}
    </button>

    <div @if ($tooltip) id="tooltip-{{ $tooltip }}" @endif  role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 
        bg-rose-500 rounded-lg shadow-sm opacity-0 tooltip dark:bg-rose-500">
        {{ $tooltipTitle }}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</div>
