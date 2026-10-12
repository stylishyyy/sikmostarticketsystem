<div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-gray-200 relative mb-8">
    <div class="border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Upravljanje strojevima / Opremom</h2>
        <p class="text-sm text-gray-500 mt-1">Evidencija fizičke opreme i strojeva u pogonu.</p>
    </div>

    @if (session()->has('asset_message'))
        <div class="p-4 mb-6 text-sm font-medium rounded-lg" style="background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;">
            {{ session('asset_message') }}
        </div>
    @endif

    <div class="p-6 rounded-lg mb-8" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
        <form wire:submit.prevent="addAsset" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-grow w-full">
                <label class="block text-sm font-bold text-gray-700 uppercase mb-2">Naziv stroja / opreme</label>
                <input type="text" wire:model="name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-2.5 px-3" placeholder="Unesite naziv (npr. CNC Stroj Haas VF7)">
            </div>
            <button type="submit" class="w-full md:w-auto text-white text-sm font-bold py-2.5 px-8 rounded shadow-sm transition-colors flex justify-center items-center gap-2 h-[46px]" style="background-color: #1e293b;">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Dodaj opremu
            </button>
        </form>
        @error('name') <span class="text-red-500 text-sm font-bold mt-2 block">{{ $message }}</span> @enderror
    </div>

    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="text-left text-base text-gray-600" style="width: 100%;">
            <thead class="text-xs uppercase tracking-wider text-gray-600" style="background-color: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                <tr>
                    <th class="p-4 font-bold" style="width: 10%;">ID</th>
                    <th class="p-4 font-bold" style="width: 75%;">Oprema / Stroj</th>
                    <th class="p-4 font-bold text-center" style="width: 15%;">Akcija</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($assets as $asset)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 font-black" style="color: #94a3b8;">#{{ str_pad($asset->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="p-4 font-bold text-gray-800 flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        {{ $asset->name }}
                    </td>
                    <td class="p-4 text-center">
                        <button wire:click="deleteAsset({{ $asset->id }})" wire:confirm="Jeste li sigurni da želite obrisati ovu opremu?" class="text-sm font-bold flex items-center justify-center gap-1 mx-auto hover:underline" style="color: #dc2626;">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            Obriši
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-8 text-center text-gray-500 text-base">Nema unesene opreme.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>