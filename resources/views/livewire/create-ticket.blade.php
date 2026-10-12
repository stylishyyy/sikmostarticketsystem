<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-gray-200 relative mb-8 mt-6">

    <div class="border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Nova prijava kvara / zahtjeva</h2>
        <p class="text-sm text-gray-500 mt-1">Ispunite formu ispod za otvaranje novog IT tiketa.</p>
    </div>
        
    @if (session()->has('message'))
        <div class="p-4 mb-6 text-sm font-medium rounded-lg" style="background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;">
            {{ session('message') }}
        </div>
    @endif

    <!-- PRIKAZ GREŠAKA PRI UNOSU (Ovo će nam reći zašto puca ako padne) -->
    @if ($errors->any())
        <div class="p-4 mb-6 text-sm font-medium rounded-lg" style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca;">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">
        
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Naslov</label>
            <input type="text" wire:model="title" placeholder="Kratak opis problema..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
        </div>
        
        <div x-data="{
            kategorijaId: '',
            vsePodkategorije: {{ $categories->mapWithKeys(function($c) { return [$c->id => $c->subcategories]; })->toJson() }},
            prikazanePodkategorije: []
        }" class="space-y-6">
            
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Kategorija</label>
                <select wire:model="category_id" 
                        x-model="kategorijaId" 
                        x-on:change="prikazanePodkategorije = vsePodkategorije[kategorijaId] || []" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3" style="background-color: #f8fafc;">
                    <option value="">-- Odaberite --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Potkategorija</label>
                <select wire:model="subcategory_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3" style="background-color: #f8fafc;">
                    <option value="">-- Neobavezno --</option>
                    <template x-for="sub in prikazanePodkategorije" :key="sub.id">
                        <option x-bind:value="sub.id" x-text="sub.name"></option>
                    </template>
                </select>
            </div>
            
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Stroj / Oprema (Opcionalno)</label>
            <select wire:model="asset_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3" style="background-color: #f8fafc;">
                <option value="">-- Nije vezano --</option>
                @foreach($assets as $asset)
                    <option value="{{ $asset->id }}">{{ $asset->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Detaljan opis kvara</label>
            <textarea wire:model="description" rows="5" placeholder="Opišite što se točno dogodilo..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm p-3"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 rounded-lg" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Prioritet (SLA)</label>
                <select wire:model="priority" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
                    <option value="low">Nizak (Rok: 72h)</option>
                    <option value="medium">Srednji (Rok: 24h)</option>
                    <option value="high">Visok (Rok: 8h)</option>
                    <option value="critical">Kritičan (Rok: 2h)</option>
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Uputi korisniku</label>
                <select wire:model="assigned_to" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
                    <option value="">-- Nedodijeljeno --</option>
                    @foreach($workers as $worker)
                        <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Slika ili privitak (do 5MB)</label>
                <input type="file" wire:model="attachment" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                <div wire:loading wire:target="attachment" class="text-xs text-indigo-600 mt-1 font-bold">Učitavanje datoteke...</div>
            </div>
        </div>
        
        <div class="flex justify-end pt-4">
            <button type="submit" class="text-white text-sm font-bold py-3 px-10 rounded shadow-sm transition-colors flex items-center gap-2" style="background-color: #4f46e5;">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Prijavi kvar
            </button>
        </div>
    </form>
</div>