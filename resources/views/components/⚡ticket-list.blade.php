<div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-gray-100 mt-8 relative">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">🖥️ IT Kontrolna ploča (Svi tiketi)</h2>
    
    @if (session()->has('note_message'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg font-medium border border-green-200">
            {{ session('note_message') }}
        </div>
    @endif

    <div class="overflow-x-auto">
    <div class="flex gap-4 mb-6 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
    <input type="text" wire:model.live="search" placeholder="Pretraži tikete..." class="border rounded-md px-3 py-2 w-1/3">
    
    <select wire:model.live="statusFilter" class="border rounded-md px-3 py-2">
        <option value="">Svi statusi</option>
        <option value="novo">Novo</option>
        <option value="u obradi">U obradi</option>
        <option value="riješeno">Riješeno</option>
    </select>

    <select wire:model.live="categoryFilter" class="border rounded-md px-3 py-2">
        <option value="">Sve kategorije</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select>
</div>    
    <table class="min-w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-800 border-b">
                <tr>
                    <th class="p-4 font-semibold">ID</th>
                    <th class="p-4 font-semibold">Kvar i Opis</th>
                    <th class="p-4 font-semibold">Prijavio</th>
                    <th class="p-4 font-semibold">Kategorija</th>
                    <th class="p-4 font-semibold">Prioritet</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold text-center">Akcije</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($tickets as $ticket)
                <tr class="hover:bg-gray-50 transition-colors 
    @if($ticket->priority == 'critical') bg-red-50 border-l-4 border-red-500 
    @elseif($ticket->priority == 'high') bg-orange-50 border-l-4 border-orange-500 
    @endif">
                    <td class="p-4 font-bold text-indigo-600">#{{ $ticket->id }}</td>
                    <td class="p-4">
                        <div class="font-bold text-gray-900">{{ $ticket->title }}</div>
                        <div class="text-xs text-gray-500 mt-1 truncate max-w-xs">{{ $ticket->description }}</div>
                    </td>
                    <td class="p-4 font-medium">{{ $ticket->user->name }}</td>
                    <td class="p-4">{{ $ticket->category->name }}</td>
                    <td class="p-4">
                        @if($ticket->priority == 'critical') 
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">Kritično</span>
                        @elseif($ticket->priority == 'high') 
                            <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-bold">Visoko</span>
                        @elseif($ticket->priority == 'medium') 
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-bold">Srednje</span>
                        @else 
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">Nisko</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <select wire:change="updateStatus({{ $ticket->id }}, $event.target.value)" class="text-sm rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900">
                            <option value="novo" {{ $ticket->status == 'novo' ? 'selected' : '' }}>Novo</option>
                            <option value="u_obradi" {{ $ticket->status == 'u_obradi' ? 'selected' : '' }}>U obradi</option>
                            <option value="rijeseno" {{ $ticket->status == 'rijeseno' ? 'selected' : '' }}>Riješeno</option>
                        </select>
                    </td>
                    <td class="p-4 text-center">
                        <button wire:click="openModal({{ $ticket->id }})" class="bg-gray-800 hover:bg-gray-900 text-white text-xs font-bold py-1.5 px-3 rounded shadow transition-colors">
                            Detalji i Bilješke
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                        IT Bilješka za Tiket #{{ $selectedTicketId }}
                    </h3>
                    @if($attachment_path)
                        <div class="mb-4 bg-gray-50 p-3 rounded border border-gray-200 text-center">
                            <span class="block text-xs font-bold text-gray-500 mb-2 uppercase">Priložena fotografija / dokument</span>
                            <a href="{{ asset('storage/' . $attachment_path) }}" target="_blank" class="inline-block">
                                @if(\Illuminate\Support\Str::endsWith(strtolower($attachment_path), ['.jpg', '.jpeg', '.png']))
                                    <img src="{{ asset('storage/' . $attachment_path) }}" alt="Prilog kvara" class="max-h-48 rounded shadow-sm border border-gray-300 hover:opacity-80 transition-opacity">
                                @else
                                    <span class="text-indigo-600 font-semibold hover:underline">📎 Otvori / Preuzmi dokument</span>
                                @endif
                            </a>
                        </div>
                    @endif
                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Interni komentar / Odgovor radniku</label>
                        <textarea wire:model="admin_notes" rows="5" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900" placeholder="Npr. Čekamo novi dio za kran, bit će riješeno u ponedjeljak..."></textarea>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="saveNotes" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Spremi bilješku
                    </button>
                    <button wire:click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Odustani
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>