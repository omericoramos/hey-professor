<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dê seu voto para as perguntas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <form actio={{ route('dashboard') }} method="get">
                    @csrf
                    <input class="w-1/3 rounded-md" type="text" name="search" value="{{ request()->search }}">
                    <button class="btn bg-blue-500 text-slate-100 px-4 py-2 mx-2 rounded-md hover:bg-blue-700"
                        type="submit">Pesquisar</button>
                </form>
                <h1 class="dark:text-slate-500 uppercase text-xl font-semibold my-6">Lista de perguntas</h1>
                @if ($questions->isEmpty())
                    <div class="text-2xl mx-10 text-slate-200">
                        <h1>Nenhuma pergunta encontrada</h1>
                    </div>
                @else
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
                                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <x-table.td>{{ $item->id }}</x-table.td>
                                    <x-table.td>{{ $item->question }}</x-table.td>
                                    <x-table.td>{{ $item->created_at }}</x-table.td>
                                    <x-table.td><x-thumbs :question="$item" /></x-table.td>
                                </tr>
                            @endforeach
                        </x-table.tbody>
                    </x-table.table>
                @endif

                <div class="p-4 m-4">
                    {{ $questions->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
