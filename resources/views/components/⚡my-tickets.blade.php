<div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-gray-100 mt-8">
    <h2 class="text-xl font-bold mb-6 text-gray-800">📋 Moji prijavljeni kvarovi</h2>
    
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-800 border-b">
                <tr>
                    <th class="p-4 font-semibold">Kvar i Opis</th>
                    <th class="p-4 font-semibold">Kategorija</th>
                    <th class="p-4 font-semibold text-center">Status</th>
                    <th class="p-4 font-semibold">Odgovor IT odjela</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($tickets as $ticket)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4">
                        <div class="font-bold text-gray-900">{{ $ticket->title }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ $ticket->description }}</div>
                        <div class="text-xs text-gray-400 mt-2">{{ $ticket->created_at->format('d.m.Y H:i') }}</div>
                    </td>
                    <td class="p-4">{{ $ticket->category->name }}</td>
                    <td class="p-4 text-center">
                        @if($ticket->status == 'novo')
                            <span class="bg-blue-100 text-blue-700 px-2.5 py-1 rounded-full text-xs font-bold">Novo</span>
                        @elseif($ticket->status == 'u_obradi')
                            <span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-full text-xs font-bold">U obradi</span>
                        @else
                            <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-bold">Riješeno</span>
                        @endif
                    </td>
                    <td class="p-4">
                        @if($ticket->admin_notes)
                            <div class="bg-indigo-50 border-l-4 border-indigo-500 p-2 text-indigo-700 text-xs rounded">
                                {{ $ticket->admin_notes }}
                            </div>
                        @else
                            <span class="text-gray-400 text-xs italic">Nema odgovora...</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @if($tickets->isEmpty())
            <div class="p-6 text-center text-gray-500 font-medium bg-gray-50 mt-4 rounded">
                Još niste prijavili niti jedan kvar.
            </div>
        @endif
    </div>
</div>