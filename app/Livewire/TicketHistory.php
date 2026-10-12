<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // Dodano za paginaciju
use App\Models\Ticket;
use App\Models\User; 

class TicketHistory extends Component
{
    use WithPagination; // Uključivanje paginacije

    public $workerFilter = ''; 

    // Resetiraj na prvu stranicu kad se promijeni filter radnika
    public function updatingWorkerFilter() 
    { 
        $this->resetPage(); 
    }

    public function deleteTicket($id)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            $ticket->delete();
            session()->flash('history_message', 'Tiket je trajno obrisan iz arhive.');
        }
    }

    public function render()
    {
        // Dohvaćamo tikete, dodajemo provjeru i ograničavamo na 10 po stranici
        $tickets = Ticket::with(['user', 'category', 'assignedWorker'])
            ->where('status', 'rijeseno')
            ->when($this->workerFilter, function($query) {
                $query->where('assigned_to', $this->workerFilter);
            })
            ->latest()
            ->paginate(10); // Zamijenjeno get() s paginate(10)

        // Dohvaćamo sve korisnike za padajući izbornik filtera
        $workers = User::orderBy('name')->get();

        return view('livewire.ticket-history', [
            'tickets' => $tickets,
            'workers' => $workers
        ]);
    }
}