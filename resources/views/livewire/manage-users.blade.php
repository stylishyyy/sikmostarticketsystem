<div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-gray-200 relative mb-8">
    <div class="border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Upravljanje korisničkim računima</h2>
        <p class="text-sm text-gray-500 mt-1">Dodavanje novih zaposlenika i upravljanje pravima pristupa sustavu.</p>
    </div>

    @if (session()->has('user_message'))
        <div class="p-4 mb-6 text-sm font-medium rounded-lg" style="background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;">
            {{ session('user_message') }}
        </div>
    @endif
    @if (session()->has('user_error'))
        <div class="p-4 mb-6 text-sm font-medium rounded-lg" style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;">
            {{ session('user_error') }}
        </div>
    @endif

    <div class="p-6 rounded-lg mb-8" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Kreiraj novog korisnika</h3>
        <form action="{{ route('users.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            @csrf
            <div class="lg:col-span-1">
                <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Ime i prezime</label>
                <input type="text" name="name" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
            </div>
            <div class="lg:col-span-1">
                <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Email adresa</label>
                <input type="email" name="email" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
            </div>
            <div class="lg:col-span-1">
                <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Lozinka</label>
                <input type="password" name="password" required minlength="8" placeholder="Min. 8 znakova" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
            </div>
            <div class="lg:col-span-1">
                <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Uloga</label>
                <select name="role" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3">
                    <option value="zaposlenik">Zaposlenik (Samo prijava)</option>
                    <option value="it">IT Admin (Puni pristup)</option>
                </select>
            </div>
            <div class="lg:col-span-1">
                <button type="submit" class="w-full text-white text-sm font-bold py-2 px-4 rounded shadow-sm transition-colors flex justify-center items-center gap-2 h-[38px]" style="background-color: #4f46e5;">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    Spremi
                </button>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="text-left text-sm text-gray-600" style="width: 100%;">
            <thead class="text-xs uppercase tracking-wider text-gray-600" style="background-color: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                <tr>
                    <th class="p-4 font-bold" style="width: 25%;">Korisnik</th>
                    <th class="p-4 font-bold" style="width: 35%;">Email adresa</th>
                    <th class="p-4 font-bold text-center" style="width: 15%;">Uloga</th>
                    <th class="p-4 font-bold text-center" style="width: 15%;">Kreiran</th>
                    <th class="p-4 font-bold text-center" style="width: 10%;">Akcija</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach(\App\Models\User::orderBy('id')->get() as $u)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 font-bold text-gray-800 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-black shadow-sm" style="background-color: #94a3b8;">
                            {{ strtoupper(substr($u->name, 0, 1)) }}
                        </div>
                        {{ $u->name }}
                    </td>
                    <td class="p-4 text-gray-500 font-medium">{{ $u->email }}</td>
                    <td class="p-4 text-center">
                        @if($u->role == 'it' || $u->role == 'admin')
                            <span class="px-2 py-1 text-[10px] font-black rounded shadow-sm uppercase" style="background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe;">IT Admin</span>
                        @else
                            <span class="px-2 py-1 text-[10px] font-black rounded shadow-sm uppercase" style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">Zaposlenik</span>
                        @endif
                    </td>
                    <td class="p-4 text-center text-gray-500 font-medium">{{ $u->created_at->format('d.m.Y') }}</td>
                    <td class="p-4 text-center">
                        @if($u->id != auth()->id())
                            <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Jeste li sigurni da želite obrisati ovog korisnika?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-bold flex items-center justify-center gap-1 mx-auto hover:underline" style="color: #dc2626;">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    Obriši
                                </button>
                            </form>
                        @else
                            <span class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Vaš profil</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>