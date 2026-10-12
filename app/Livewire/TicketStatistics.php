<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class TicketStatistics extends Component
{
    public function render()
    {
        // Osnovna statistika
        $totalTickets = Ticket::count();
        $resolvedTickets = Ticket::where('status', 'rijeseno')->count();
        $openTickets = Ticket::whereIn('status', ['novo', 'u_obradi', 'u obradi'])->count();
        $criticalTickets = Ticket::where('priority', 'critical')->count();

        // Top 5 radnika po broju riješenih tiketa
        $topWorkers = Ticket::with('assignedWorker')
            ->select('assigned_to', DB::raw('count(*) as total'))
            ->where('status', 'rijeseno')
            ->whereNotNull('assigned_to')
            ->groupBy('assigned_to')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Top 5 opreme/strojeva s najviše prijavljenih kvarova
        $topAssets = Ticket::with('asset')
            ->select('asset_id', DB::raw('count(*) as total'))
            ->whereNotNull('asset_id')
            ->groupBy('asset_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('livewire.ticket-statistics', [
            'totalTickets' => $totalTickets,
            'resolvedTickets' => $resolvedTickets,
            'openTickets' => $openTickets,
            'criticalTickets' => $criticalTickets,
            'topWorkers' => $topWorkers,
            'topAssets' => $topAssets,
        ]);
    }
}