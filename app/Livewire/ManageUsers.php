<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManageUsers extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $role = 'zaposlenik';

    public function createUser()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        $this->reset(['name', 'email', 'password']);
        $this->role = 'zaposlenik'; 
        
        session()->flash('user_message', 'Korisnik uspješno kreiran.');
    }

    public function render()
    {
        return view('livewire.manage-users', [
            'users' => User::orderBy('name', 'asc')->get()
        ]);
    }
}