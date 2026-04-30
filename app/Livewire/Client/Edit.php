<?php

namespace App\Livewire\Client;

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
    public $password;
    public $avatar;
    public $is_active;
    public $selectedProjects = [];

    public function mount($id)
    {
        $client = User::with('projects')->findOrFail($id);
        $this->id = $client->id;
        $this->name = $client->name;
        $this->email = $client->email;
        $this->phone = $client->phone;
        $this->address = $client->address;
        $this->role = $client->role;
        $this->avatar = $client->avatar;
        $this->is_active = $client->is_active;
        $this->selectedProjects = $client->projects->pluck('id')->map(fn($id) => (string)$id)->toArray();
    }

    public function render()
    {
        $projects = Project::where('is_active', true)->orderBy('name')->get();
        return view('livewire.client.edit', compact('projects'));
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

        $client = User::findOrFail($this->id);
        $client->name = $this->name;
        $client->email = $this->email;
        $client->phone = $this->phone;
        $client->address = $this->address;
        $client->role = $this->role;
        $client->type = 2;
        $client->avatar = $this->avatar;
        $client->is_active = $this->is_active;

        if ($this->password) {
            $client->password = Hash::make($this->password);
        }
        $client->save();

        // Sync projects
        $client->projects()->sync($this->selectedProjects);

        session()->flash('message', 'Client updated successfully');

        return redirect()->route('clients');
    }
}
