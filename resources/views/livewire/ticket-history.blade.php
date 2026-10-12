<div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-gray-200 relative mb-8">
    <div class="border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Arhiva završenih radova</h2>
        <p class="text-sm text-gray-500 mt-1">Trajni pregled svih riješenih i zatvorenih tiketa u sustavu.</p>
    </div>
    
    @if (session()->has('history_message'))
        <div class="p-4 mb-6 text-sm font-medium rounded-lg" style="background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;">
            {{ session('history_message') }}
        </div>
    @endif

    <div class="flex items-center gap-4 mb-6 p-4 rounded-lg" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
        <div class="w-full md:w-1/3 relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <select wire:model.live="workerFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 pl-9 pr-3" style="appearance: none;">
                <option value="">Svi radnici (Pretraga)</option>
                @foreach($workers as $worker)
                    <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="text-left text-sm text-gray-600" style="width: 100%;">
            <thead class="text-xs uppercase tracking-wider text-gray-600" style="background-color: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                <tr>
                    <th class="p-4 font-bold" style="width: 10%;">ID</th>
                    <th class="p-4 font-bold" style="width: 25%;">Naslov kvara</th>
                    <th class="p-4 font-bold" style="width: 15%;">Prijavio</th>
                    <th class="p-4 font-bold" style="width: 15%;">Riješio (Radnik)</th>
                    <th class="p-4 font-bold" style="width: 13%;">Datum prijave</th>
                    <th class="p-4 font-bold" style="width: 12%;">Završeno</th>
                    <th class="p-4 font-bold text-center" style="width: 10%;">Akcija</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($tickets as $ticket)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 font-black" style="color: #94a3b8;">#{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="p-4 font-bold text-gray-800">{{ $ticket->title }}</td>
                    <td class="p-4 font-medium text-gray-600">{{ $ticket->user->name ?? 'Nepoznato' }}</td>
                    
                    <td class="p-4">
                        <span class="px-2 py-1 text-[10px] font-black rounded shadow-sm uppercase" style="background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;">
                            {{ $ticket->assignedWorker->name ?? 'Nedodijeljeno' }}
                        </span>
                    </td>
                    
                    <td class="p-4 text-gray-500 font-medium">{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                    
                    <td class="p-4 font-bold" style="color: #059669;">
                        {{ $ticket->completed_at ? \Carbon\Carbon::parse($ticket->completed_at)->format('d.m.Y H:i') : 'N/A' }}
                    </td>
                    
                    <td class="p-4 text-center">
                        <button wire:click="deleteTicket({{ $ticket->id }})" 
                                wire:confirm="Jeste li sigurni da želite trajno obrisati ovaj tiket iz arhive?" 
                                class="text-sm font-bold flex items-center justify-center gap-1 mx-auto hover:underline" style="color: #dc2626;">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            Obriši
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500 text-base">
                        @if($workerFilter)
                            Odabrani radnik nema riješenih tiketa.
                        @else
                            Trenutno nema arhiviranih tiketa.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $tickets->links() }}
    </div>
</div>