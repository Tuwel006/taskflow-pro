<?php

namespace App\Livewire\Client;

use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $email;
    public $phone;
    public $address;
    public $role = 'Client';
    public $type = 2;
    public $password;
    public $avatar;
    public $is_active = true;

    public function render()
    {
        return view('livewire.client.create');
    }

    public function store()
    {
        $validated = $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'address' => 'required',
            'role' => 'required',
            'password' => 'required|min:6',
            'avatar' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        $validated['type'] = 2;
        User::create($validated);

        session()->flash('success', 'Client created successfully');

        return $this->redirect('/clients', navigate: true);
    }
}
