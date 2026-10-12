<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-gray-100 mt-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">🛠️ Prijavi novi kvar / zahtjev</h2>

    @if (session()->has('message'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg font-medium border border-green-200">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-5">
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategorija kvara</label>
            <select wire:model="category_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900">
                <option value="">-- Odaberi kategoriju --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="text-red-500 text-xs font-semibold">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kratki naslov problema</label>
            <input type="text" wire:model="title" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900" placeholder="Npr. Ne radi printer u uredu 3">
            @error('title') <span class="text-red-500 text-xs font-semibold">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Detaljan opis</label>
            <textarea wire:model="description" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900" placeholder="Opiši točno što se događa i kada se problem pojavio..."></textarea>
            @error('description') <span class="text-red-500 text-xs font-semibold">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Prioritet</label>
            <select wire:model="priority" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900">
                <option value="low">Nisko (Može čekati)</option>
                <option value="medium">Srednje (Otežava rad)</option>
                <option value="high">Visoko (Hitno, rad zaustavljen)</option>
                <option value="critical">Kritično (Cijeli sustav stoji)</option>
            </select>
            @error('priority') <span class="text-red-500 text-xs font-semibold">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Priloži sliku kvara (Nije obavezno)</label>
            <input type="file" wire:model="attachment" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer border border-gray-300 rounded-md p-1">
            
            <div wire:loading wire:target="attachment" class="text-sm text-blue-600 mt-2 font-medium">
                ⏳ Učitavanje slike...
            </div>
            
            @error('attachment') <span class="text-red-500 text-xs font-semibold">{{ $message }}</span> @enderror
            
            @if ($attachment)
                <div class="mt-2 text-sm text-green-600 font-medium">✅ Datoteka uspješno dodana!</div>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                <svg wire:loading wire:target="submit" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                POŠALJI PRIJAVU KVARA
            </button>
        </div>
    </form>
</div>