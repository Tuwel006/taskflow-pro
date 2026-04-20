<?php

namespace App\Livewire\User;

use Livewire\Component;

class Create extends Component
{
    public function render()
    {
        return view('livewire.user.create');
    }

    public function store()
    {
        $validated = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'role' => 'required',
            'password' => 'required',
            'avatar' => 'required',
            'is_active' => 'required',
        ]);

        $user = User::create($validated);

        session()->flash('success', 'User created successfully');

        return redirect()->route('users');
    }
}
