<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Asset;

class ManageAssets extends Component
{
    public $name = '';
    public $editId = null;
    public $editName = '';

    public function store()
    {
        $this->validate(['name' => 'required|min:2']);
        Asset::create(['name' => $this->name]);
        $this->name = '';
        session()->flash('asset_message', 'Stroj/Oprema uspješno dodana.');
    }

    public function edit($id)
    {
        $asset = Asset::find($id);
        $this->editId = $asset->id;
        $this->editName = $asset->name;
    }

    public function update()
    {
        $this->validate(['editName' => 'required|min:2']);
        $asset = Asset::find($this->editId);
        $asset->update(['name' => $this->editName]);
        $this->editId = null;
        $this->editName = '';
        session()->flash('asset_message', 'Stroj/Oprema uspješno ažurirana.');
    }

    public function delete($id)
    {
        Asset::find($id)->delete();
        session()->flash('asset_message', 'Stroj/Oprema uspješno obrisana.');
    }

    public function render()
    {
        return view('livewire.manage-assets', [
            'assets' => Asset::orderBy('name')->get()
        ]);
    }
}