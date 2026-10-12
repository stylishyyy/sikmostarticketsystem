<div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-gray-100 mt-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">👥 Upravljanje korisničkim računima</h2>

    @if (session()->has('user_message'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg font-medium border border-green-200">
            {{ session('user_message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 h-fit">
            <h3 class="text-md font-bold text-gray-700 mb-4">Kreiraj novog korisnika</h3>
            <form wire:submit.prevent="createUser" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Ime i prezime</label>
                    <input type="text" wire:model="name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    @error('name') <span class="text-red-500 text-xs font-semibold">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Email adresa</label>
                    <input type="email" wire:model="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    @error('email') <span class="text-red-500 text-xs font-semibold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Lozinka (min. 8 znakova)</label>
                    <input type="password" wire:model="password" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    @error('password') <span class="text-red-500 text-xs font-semibold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Uloga / Prava pristupa</label>
                    <select wire:model="role" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="zaposlenik">Zaposlenik (Samo prijava kvara)</option>
                        <option value="it">IT Odjel (Puni pristup)</option>
                    </select>
                    @error('role') <span class="text-red-500 text-xs font-semibold">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow text-sm font-medium transition-colors mt-2">
                    Spremi korisnika
                </button>
            </form>
        </div>

        <div class="md:col-span-2">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-800 border-b">
                        <tr>
                            <th class="p-4 font-semibold">Ime i prezime</th>
                            <th class="p-4 font-semibold">Email</th>
                            <th class="p-4 font-semibold text-center">Uloga</th>
                            <th class="p-4 font-semibold text-center">Kreiran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $u)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 font-medium text-gray-900">{{ $u->name }}</td>
                            <td class="p-4">{{ $u->email }}</td>
                            <td class="p-4 text-center">
                                @if($u->role === 'it')
                                    <span class="bg-indigo-100 text-indigo-700 px-2.5 py-1 rounded-full text-xs font-bold">IT Admin</span>
                                @else
                                    <span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full text-xs font-bold">Zaposlenik</span>
                                @endif
                            </td>
                            <td class="p-4 text-center text-xs text-gray-400">
                                {{ $u->created_at->format('d.m.Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>