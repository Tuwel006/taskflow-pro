<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public $name;

    public $email;

    public $phone;

    public $address;

    public $role;

    public $type = 0;

    public $password;

    public $avatar;

    public $is_active = true;

    public function render()
    {
        return view('livewire.user.create');
    }

    public function store()
    {
        $validated = $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'address' => 'required',
            'role' => 'required',
            'type' => 'required|integer',
            'password' => 'required|min:6',
            'avatar' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        User::create($validated);

        // Fire the custom 'published' event
        $this->fireModelEvent('status_changed', false);

        session()->flash('success', 'User created successfully');

        return $this->redirect('/users', navigate: true);
    }
}
