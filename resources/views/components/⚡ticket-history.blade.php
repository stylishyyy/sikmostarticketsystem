<div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-gray-100 mt-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">📜 Arhiva završenih radova</h2>
    
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-800 border-b">
                <tr>
                    <th class="p-4 font-semibold">Stroj/Kategorija</th>
                    <th class="p-4 font-semibold">Problem</th>
                    <th class="p-4 font-semibold">Datum prijave</th>
                    <th class="p-4 font-semibold">Datum popravka</th>
                    <th class="p-4 font-semibold text-center">Trajanje</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($history as $ticket)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 font-medium">{{ $ticket->category->name }}</td>
                    <td class="p-4">{{ $ticket->title }}</td>
                    <td class="p-4 text-gray-400">{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                    <td class="p-4 text-green-600 font-bold">{{ $ticket->completed_at ? \Carbon\Carbon::parse($ticket->completed_at)->format('d.m.Y H:i') : '-' }}</td>
                    <td class="p-4 text-center">
                        <span class="bg-gray-100 px-2 py-1 rounded text-xs">
                            {{ $ticket->completed_at ? $ticket->created_at->diffForHumans($ticket->completed_at, true) : '-' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>