<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // NOVO: Klasa za paginaciju
use App\Models\Ticket;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketNotification;

class TicketList extends Component
{
    use WithPagination; // NOVO: Uključivanje paginacije u komponentu

    public $isModalOpen = false;
    public $selectedTicketId = null;
    public $admin_notes = '';
    public $attachment_path = null;

    public $search = '';
    public $statusFilter = '';
    public $categoryFilter = '';

    // NOVO: Ako netko pretražuje, želimo ga vratiti na prvu stranicu
    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingCategoryFilter() { $this->resetPage(); }

    public function updateStatus($ticketId, $newStatus)
    {
        $ticket = Ticket::find($ticketId);
        
        $data = ['status' => $newStatus];
        
        if ($newStatus == 'rijeseno') {
            $data['completed_at'] = now();
        } else {
            $data['completed_at'] = null;
        }

        $ticket->update($data);

        if ($newStatus == 'rijeseno' && $ticket->user) {
            Mail::to($ticket->user->email)->send(new TicketNotification($ticket, 'Vaš kvar/zahtjev je uspješno riješen od strane IT službe!'));
        }
    }

    public function assignTicket($ticketId, $userId)
    {
        $ticket = Ticket::find($ticketId);
        if ($ticket) {
            $ticket->update([
                'assigned_to' => $userId ?: null
            ]);
            
            if ($userId) {
                $worker = User::find($userId);
                if ($worker) {
                    Mail::to($worker->email)->send(new TicketNotification($ticket, 'Dobili ste novi zadatak: Zaduženi ste za rješavanje ovog kvara.'));
                }
            }

            session()->flash('note_message', 'Tiket je uspješno zadužen radniku!');
        }
    }

    public function deleteTicket($id)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            $ticket->delete();
            session()->flash('note_message', 'Tiket je uspješno obrisan.');
        }
    }

    public function openModal($ticketId)
    {
        $ticket = Ticket::find($ticketId);
        $this->selectedTicketId = $ticket->id;
        $this->admin_notes = $ticket->admin_notes;
        $this->attachment_path = $ticket->attachment_path;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function saveNotes()
    {
        if ($this->selectedTicketId) {
            Ticket::find($this->selectedTicketId)->update([
                'admin_notes' => $this->admin_notes
            ]);
            $this->closeModal();
            session()->flash('note_message', 'Bilješka je uspješno spremljena!');
        }
    }

    public function render()
    {
        $tickets = Ticket::with(['user', 'category', 'assignedWorker', 'asset'])
            ->when($this->search, function($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->categoryFilter, function($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->latest()
            ->paginate(10); // PROMJENA: Umjesto get(), sada koristimo paginate(10)

        $workers = User::orderBy('name')->get();

        return view('livewire.ticket-list', [
            'tickets' => $tickets,
            'categories' => Category::all(),
            'workers' => $workers
        ]);
    }
}