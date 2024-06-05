@props(['questions', 'draft'])

<x-table.table>
    <x-table.thead>
        <tr>
            <x-table.th>Código</x-tabel.th>
                <x-table.th>Pergunta</x-tabel.th>
                    <x-table.th>Criada em</x-tabel.th>
                        @if ($draft == true)
                            <x-table.th>ações</x-tabel.th>
                        @endif
        </tr>
    </x-table.thead>

    <x-table.tbody>
        @foreach ($questions as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <x-table.td>{{ $item->id }}</x-table.td>
                <x-table.td>{{ $item->question }}</x-table.td>
                <x-table.td>{{ $item->created_at }}</x-table.td>
                @if ($draft == true)
                    <x-table.td>
                        <div class="flex justify-between">
                            <a href="{{ route('question.edit', $item) }}">
                                <x-btn.primery-button tooltip='Editar'>
                                    <x-icons.edit />
                                </x-btn.primery-button>
                            </a>
                            <x-form :action="route('question.publish', $item)" put>
                                <x-btn.primery-button tooltip='Publicar'>
                                    <x-icons.publish />
                                </x-btn.primery-button>
                            </x-form>

                            <x-form :action="route('question.destroy', $item)" delete>
                                <x-btn.danger-button tooltip='Deletar'>
                                    <x-icons.trash />
                                </x-btn.danger-button>
                            </x-form>

                        </div>
                    </x-table.td>
                @endif

            </tr>
        @endforeach
    </x-table.tbody>
</x-table.table>
