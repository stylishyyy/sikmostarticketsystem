<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketNotification;

Route::get('/ocisti-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return 'Cache je uspješno obrisan!';
});

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    $workers = User::orderBy('name')->get();
    $all_users = User::orderBy('id')->get();
    
    $my_tickets = Ticket::with('assignedWorker')
        ->where('user_id', auth()->id())
        ->whereIn('status', ['novo', 'u_obradi', 'u obradi'])
        ->latest()
        ->get();
        
    $my_archive = Ticket::with('assignedWorker')
        ->where('user_id', auth()->id())
        ->where('status', 'rijeseno')
        ->latest()
        ->get();
    
    return view('dashboard', compact('workers', 'all_users', 'my_tickets', 'my_archive'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// UPRAVLJANJE KORISNICIMA
Route::post('/users/store', function (Request $request) {
    if (auth()->user()->role !== 'admin') { abort(403); }
    $request->validate([
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'role' => 'required',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return back()->with('user_message', 'Korisnik uspješno kreiran.');
})->name('users.store')->middleware('auth');

Route::delete('/users/{id}', function ($id) {
    if (auth()->user()->role !== 'admin') { abort(403); }
    if (auth()->id() == $id) {
        return back()->with('user_error', 'Ne možete obrisati vlastiti raèun.');
    }

    $user = User::find($id);
    if ($user) {
        $user->delete();
        return back()->with('user_message', 'Korisnik je uspješno obrisan.');
    }

    return back()->with('user_error', 'Korisnik nije pronaðen.');
})->name('users.destroy')->middleware('auth');

// PRIJAVA KVARA (SLA Rokovi i Mail Notifikacije)
Route::post('/tickets/store', function (Request $request) {
    $request->validate([
        'category_id' => 'required',
        'title' => 'required|min:3',
        'description' => 'required',
        'priority' => 'required',
        'assigned_to' => 'nullable', 
        'asset_id' => 'nullable', 
        'attachments' => 'nullable|array|max:5',
        'attachments.*' => 'file|max:10240',
    ], [
        'attachments.max' => 'Možete priložiti maksimalno 5 datoteka.'
    ]);

    $attachmentPaths = [];
    
    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $attachmentPaths[] = $file->store('tickets', 'public');
        }
    }

    // SLA PRAVILA: Raèunamo rok rješavanja na temelju odabranog prioriteta
    $dueAt = match ($request->priority) {
        'critical' => now()->addHours(2),  // Kritièno: Rok je 2 sata
        'high'     => now()->addHours(8),  // Visoko: Rok je 8 sati
        'medium'   => now()->addHours(24), // Srednje: Rok je 24 sata
        default    => now()->addHours(72), // Nizak: Rok je 3 dana (72 sata)
    };

    $ticket = Ticket::create([
        'user_id' => auth()->id(),
        'category_id' => $request->category_id,
        'asset_id' => $request->asset_id, 
        'title' => $request->title,
        'description' => $request->description,
        'priority' => $request->priority,
        'assigned_to' => $request->assigned_to, 
        'status' => 'novo',
        'due_at' => $dueAt, // Ovdje zapisujemo izraèunati rok u bazu
        'attachment_path' => count($attachmentPaths) > 0 ? json_encode($attachmentPaths) : null,
    ]);

    // Automatsko slanje emaila ako je odmah prilikom prijave odabran zaduženi radnik
    if ($ticket->assigned_to) {
        $worker = User::find($ticket->assigned_to);
        if ($worker) {
            Mail::to($worker->email)->send(new TicketNotification($ticket, 'Dobili ste novi zadatak. Postavljen je SLA rok rješavanja!'));
        }
    }

    return back()->with('message', 'Kvar je uspješno prijavljen! Rok za rješavanje je automatski dodijeljen.');
})->name('tickets.store')->middleware('auth');

require __DIR__.'/auth.php';