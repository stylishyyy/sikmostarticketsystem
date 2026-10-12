<div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-gray-200 relative mb-8">
    <div class="border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Upravljanje kategorijama</h2>
        <p class="text-sm text-gray-500 mt-1">Strukturiranje tipova kvarova (Kategorije i Potkategorije).</p>
    </div>

    @if (session()->has('category_message'))
        <div class="p-4 mb-6 text-sm font-medium rounded-lg" style="background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;">
            {{ session('category_message') }}
        </div>
    @endif

    <!-- 2 FORME (Jedna pored druge) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        
        <!-- Dodavanje Kategorije -->
        <div class="p-6 rounded-lg" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Kreiraj novu glavnu kategoriju</h3>
            <form wire:submit.prevent="addCategory" class="flex flex-col gap-4">
                <input type="text" wire:model="name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5 px-3" placeholder="Naziv (npr. Aplikacije)">
                @error('name') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                
                <button type="submit" class="w-full text-white text-sm font-bold py-2.5 px-4 rounded shadow-sm transition-colors flex justify-center items-center gap-2" style="background-color: #4f46e5;">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Spremi kategoriju
                </button>
            </form>
        </div>

        <!-- Dodavanje Potkategorije -->
        <div class="p-6 rounded-lg" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Dodaj potkategoriju u postojeću</h3>
            <form wire:submit.prevent="addSubcategory" class="flex flex-col gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <!-- ISPRAVAK: Ovdje je sada wire:model.live -->
                    <select wire:model.live="parent_category_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5 px-3">
                        <option value="">Odaberi glavnu...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    
                    <input type="text" wire:model="subcategory_name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5 px-3" placeholder="Naziv (npr. Facebook)">
                </div>
                
                @error('parent_category_id') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                @error('subcategory_name') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                
                <button type="submit" class="w-full text-white text-sm font-bold py-2.5 px-4 rounded shadow-sm transition-colors flex justify-center items-center gap-2" style="background-color: #1e293b;">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Spremi potkategoriju
                </button>
            </form>
        </div>

    </div>

    <!-- Puna širina tabele -->
    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="text-left text-sm text-gray-600" style="width: 100%;">
            <thead class="text-xs uppercase tracking-wider text-gray-600" style="background-color: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                <tr>
                    <th class="p-4 font-bold" style="width: 10%;">ID</th>
                    <th class="p-4 font-bold" style="width: 25%;">Glavna kategorija</th>
                    <th class="p-4 font-bold" style="width: 50%;">Pripadajuće potkategorije</th>
                    <th class="p-4 font-bold text-center" style="width: 15%;">Akcija</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 font-black" style="color: #94a3b8;">#{{ str_pad($category->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="p-4 font-bold text-gray-800">{{ $category->name }}</td>
                    
                    <!-- Potkategorije -->
                    <td class="p-4">
                        <div class="flex flex-wrap gap-2">
                            @forelse($category->subcategories as $sub)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold rounded shadow-sm" style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">
                                    {{ $sub->name }}
                                    <button wire:click="deleteSubcategory({{ $sub->id }})" wire:confirm="Obrisati potkategoriju '{{ $sub->name }}'?" class="text-gray-400 hover:text-red-600 transition-colors cursor-pointer" title="Obriši potkategoriju">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </span>
                            @empty
                                <span class="text-xs text-gray-400 italic">Nema potkategorija</span>
                            @endforelse
                        </div>
                    </td>

                    <td class="p-4 text-center">
                        <button wire:click="deleteCategory({{ $category->id }})" wire:confirm="Jeste li sigurni? Ovo će obrisati i sve pripadajuće potkategorije!" class="text-sm font-bold flex items-center justify-center gap-1 mx-auto hover:underline" style="color: #dc2626;">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            Obriši
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500 text-base">Nema unesenih kategorija.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>