@props(['archiveQuestions'])

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
        @foreach ($archiveQuestions as $item)
            <tr
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 overflow-hidden">
                <x-table.td>{{ $item->id }}</x-table.td>
                <x-table.td>{{ $item->question }}</x-table.td>
                <x-table.td>{{ $item->created_at }}</x-table.td>
                    <x-table.td>
                        <div class="flex justify-between">
                            <x-form :action="route('question.restore', $item)" patch>
                                <x-btn.success-button tooltip='publicar-{{ $item->id }}' tooltipTitle='Restaurar'>
                                    <x-icons.restore />
                                </x-btn.primery-button>
                            </x-form>
                        </div>
                    </x-table.td>
            </tr>
        @endforeach
    </x-table.tbody>
</x-table.table>
