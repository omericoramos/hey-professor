@props(['questions', 'draft' =>false])

<x-table.table>
    <x-table.thead>
        <tr>
            <x-table.th>Código</x-tabel.th>
                <x-table.th>Pergunta</x-tabel.th>
                    <x-table.th>Criada em</x-tabel.th>
                        <x-table.th>ações</x-tabel.th>
        </tr>
    </x-table.thead>

    <x-table.tbody>
        @foreach ($questions as $item)
            <tr
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 overflow-hidden">
                <x-table.td>{{ $item->id }}</x-table.td>
                <x-table.td>{{ $item->question }}</x-table.td>
                <x-table.td>{{ $item->created_at }}</x-table.td>
                @if ($draft == true)
                    <x-table.td>
                        <div class="flex justify-between">
                            <a href="{{ route('question.edit', $item) }}">
                                <x-btn.primery-button tooltip='editar-{{ $item->id }}' tooltipTitle='Editar'>
                                    <x-icons.edit />
                                </x-btn.primery-button>
                            </a>
                            <x-form :action="route('question.publish', $item)" put>
                                <x-btn.primery-button tooltip='publicar-{{ $item->id }}' tooltipTitle='Publicar'>
                                    <x-icons.publish />
                                </x-btn.primery-button>
                            </x-form>
                        </div>
                    </x-table.td>
                @else
                    <x-table.td>
                        <div class="flex justify-between">
                            <x-form :action="route('question.destroy', $item)" delete onsubmit="confirm('Tem certeza disso?')">
                                <x-btn.danger-button tooltip='deletar-{{ $item->id }}' tooltipTitle='Deletar'>
                                    <x-icons.trash />
                                </x-btn.danger-button>
                            </x-form>
                            <x-form :action="route('question.archive', $item)" patch>
                                <x-btn.warning-button tooltip='arquivar-{{ $item->id }}' tooltipTitle='Arquivar'>
                                    <x-icons.archive />
                                </x-btn.danger-button>
                            </x-form>
                        </div>

                    </x-table.td>
                @endif

            </tr>
        @endforeach
    </x-table.tbody>
</x-table.table>
