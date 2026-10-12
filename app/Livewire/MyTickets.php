<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketNotification;

class MyTickets extends Component
{
    public function updateStatus($ticketId, $newStatus)
    {
        $ticket = Ticket::find($ticketId);
        
        if ($ticket && $ticket->assigned_to == auth()->id()) {
            $data = ['status' => $newStatus];
            
            if ($newStatus == 'rijeseno') {
                $data['completed_at'] = now();
            } else {
                $data['completed_at'] = null;
            }

            $ticket->update($data);

            // SLANJE MAILA PRIJAVITELJU KADA ZAPOSLENIK RIJEŠI PROBLEM
            if ($newStatus == 'rijeseno' && $ticket->user) {
                Mail::to($ticket->user->email)->send(new TicketNotification($ticket, 'Vaš kvar/zahtjev je uspješno riješio zaduženi radnik!'));
            }

            session()->flash('assigned_message', 'Status tiketa je uspješno ažuriran!');
        }
    }

    public function render()
    {
        $mySubmittedTickets = Ticket::with(['assignedWorker', 'category'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $assignedToMe = Ticket::with(['user', 'category'])
            ->where('assigned_to', auth()->id())
            ->latest()
            ->get();

        return view('livewire.my-tickets', [
            'mySubmittedTickets' => $mySubmittedTickets,
            'assignedToMe' => $assignedToMe
        ]);
    }
}