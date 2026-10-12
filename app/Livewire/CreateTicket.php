<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;
use App\Models\Asset;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CreateTicket extends Component
{
    use WithFileUploads; 

    public $title = '';
    public $description = '';
    public $category_id = '';
    public $subcategory_id = ''; 
    public $asset_id = '';       
    public $priority = 'medium';
    public $assigned_to = ''; // Radnik zadužen za popravak
    public $attachment; 

    protected $rules = [
        'title' => 'required|min:5|max:255',
        'description' => 'required|min:10',
        'category_id' => 'required',
        'subcategory_id' => 'nullable',
        'asset_id' => 'nullable',
        'assigned_to' => 'nullable', // Može biti prazno
        'priority' => 'required',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', 
    ];

    public function submit()
    {
        // 1. Provjera prolaze li svi podaci validaciju
        $this->validate();

        // 2. Ako postoji slika, spremi je
        $path = null;
        if ($this->attachment) {
            $path = $this->attachment->store('attachments', 'public');
        }

        // 3. Logika za SLA (rok)
        $dueAt = match ($this->priority) {
            'critical' => now()->addHours(2),
            'high'     => now()->addHours(8),
            'medium'   => now()->addHours(24),
            default    => now()->addHours(72),
        };

        // 4. Upis u bazu
        Ticket::create([
            'user_id' => Auth::id(),
            'category_id' => $this->category_id,
            'subcategory_id' => empty($this->subcategory_id) ? null : $this->subcategory_id,
            'asset_id' => empty($this->asset_id) ? null : $this->asset_id,
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            
            // OVO JE ISPRAVAK: Ako je assigned_to prazno polje, stavi NULL, inače broj
            'assigned_to' => empty($this->assigned_to) ? null : $this->assigned_to, 
            
            'status' => 'novo',
            'due_at' => $dueAt,
            'attachment_path' => $path ? json_encode([$path]) : null,
        ]);

        // 5. Poruka i brisanje forme
        session()->flash('message', 'Kvar je uspješno prijavljen. IT odjel je obaviješten!');
        $this->reset(['title', 'description', 'category_id', 'subcategory_id', 'asset_id', 'priority', 'assigned_to', 'attachment']);
    }

    public function render()
    {
        return view('livewire.create-ticket', [
            'categories' => Category::with('subcategories')->where('is_active', true)->orderBy('name')->get(),
            'assets' => Asset::orderBy('name')->get(),
            'workers' => User::orderBy('name')->get() // Povlačimo korisnike/radnike
        ]);
    }
}