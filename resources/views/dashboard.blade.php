<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Korisnički panel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(auth()->user()->role === 'it')
                
                <div class="bg-indigo-100 text-indigo-700 p-4 rounded-lg font-bold text-center border border-indigo-200 shadow-sm" style="margin-bottom: 35px;">
                    Prijavljeni ste kao IT Administrator
                </div>
                
                <!-- 1. FORMA ZA PRIJAVU KVARA -->
                <div style="margin-bottom: 35px;">
                    <livewire:create-ticket />
                </div>
                
                <!-- 2. NOVA PLOČA SA STATISTIKOM -->
                <div style="margin-bottom: 35px;">
                    <livewire:ticket-statistics />
                </div>
                
                <!-- 3. GLAVNA TABLICA ZA SVE TIKETE -->
                <div style="margin-bottom: 35px;">
                    <livewire:ticket-list />
                </div>
                
                <!-- 4. UPRAVLJANJE KATEGORIJAMA -->
                <div style="margin-bottom: 35px;">
                    <livewire:manage-categories />
                </div>
                
                <!-- 5. UPRAVLJANJE STROJEVIMA/OPREMOM -->
                <div style="margin-bottom: 35px;">
                    <livewire:manage-assets />
                </div>
                
                <!-- 6. UPRAVLJANJE KORISNICIMA -->
                <div style="margin-bottom: 35px;">
                    <livewire:manage-users />
                </div>
                
                <!-- 7. ARHIVA -->
                <div style="margin-bottom: 35px;">
                    <livewire:ticket-history />
                </div>
                
            @else
                
                <div style="margin-bottom: 35px;">
                    <livewire:create-ticket />
                </div>
                
                <div style="margin-bottom: 35px;">
                    <livewire:my-tickets />
                </div>
                
            @endif

        </div>
    </div>
</x-app-layout>