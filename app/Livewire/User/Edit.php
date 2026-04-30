<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Edit extends Component
{
    public $id;
    public $name;
    public $email;
    public $phone;
    public $address;
    public $role;
    public $type;
    public $password;
    public $avatar;
    public $is_active;
    public $selectedProjects = [];

    public function mount($id)
    {
        $user = User::with('projects')->findOrFail($id);
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->role = $user->role;
        $this->type = $user->type;
        $this->avatar = $user->avatar;
        $this->is_active = $user->is_active;
        $this->selectedProjects = $user->projects->pluck('id')->map(fn($id) => (string)$id)->toArray();
    }

    public function render()
    {
        $projects = Project::where('is_active', true)->orderBy('name')->get();
        return view('livewire.user.edit', compact('projects'));
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'phone' => 'required',
            'address' => 'required',
            'role' => 'required',
            'is_active' => 'boolean',
            'selectedProjects' => 'nullable|array',
        ]);

        $user = User::findOrFail($this->id);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->address = $this->address;
        $user->role = $this->role;
        $user->avatar = $this->avatar;
        $user->is_active = $this->is_active;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }
        $user->save();

        // Sync projects
        $user->projects()->sync($this->selectedProjects);

        session()->flash('message', 'User updated successfully');

        return redirect()->route('users');
    }
}
