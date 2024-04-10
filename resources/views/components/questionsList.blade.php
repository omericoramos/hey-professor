@props(['questions'])

<div>
    <table class="w-full">
        <thead>
            <tr class="dark:text-slate-400  text-lg my-2">
                <th class="text-left pr-8">Código</th>
                <th class="text-left">Pergunta</th>
                <th class="text-left">Criada em</th>
                <th class="text-left">ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $item)
                <tr class="dark:text-slate-500 text-lg">
                    <td class="p-2 py-4">{{ $item->id }}</td>
                    <td>{{ $item->question }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td><x-thumbs :question="$item" /></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
