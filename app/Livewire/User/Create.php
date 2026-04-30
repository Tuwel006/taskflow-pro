<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\Project;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $email;
    public $phone;
    public $address;
    public $role;
    public $type = 1;
    public $password;
    public $avatar;
    public $is_active = true;
    public $selectedProjects = []; // Multi-select array

    public function render()
    {
        $projects = Project::where('is_active', true)->orderBy('name')->get();
        return view('livewire.user.create', compact('projects'));
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
            'selectedProjects' => 'nullable|array',
        ]);

        $validated['type'] = 1;

        $user = User::create($validated);

        // Assign projects
        if (!empty($this->selectedProjects)) {
            $user->projects()->sync($this->selectedProjects);
        }

        session()->flash('success', 'User created successfully');

        return $this->redirect('/users', navigate: true);
    }
}
