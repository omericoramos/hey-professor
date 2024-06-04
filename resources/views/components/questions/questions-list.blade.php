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

                            <x-form :action="route('question.publish',$item)" put>
                                <x-btn.primery-button text='Publicar' />
                            </x-form>

                            <x-form :action="route('question.destroy',$item)" delete>
                                <x-btn.danger-button text='Deletar' />
                            </x-form>

                        </div>
                    </x-table.td>
                @endif

            </tr>
        @endforeach
    </x-table.tbody>
</x-table.table>
