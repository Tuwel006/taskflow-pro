<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $prefix;
    public $description;
    public $is_active = true;

    protected $rules = [
        'name' => 'required|min:3|unique:projects,name',
        'prefix' => 'required|min:2|max:5|unique:projects,prefix',
        'description' => 'nullable|string',
    ];

    public function store()
    {
        $this->validate();

        Project::create([
            'name' => $this->name,
            'prefix' => strtoupper($this->prefix),
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        $this->dispatch('toast', ['message' => 'Project created successfully!', 'type' => 'success']);

        return $this->redirect('/projects', navigate: true);
    }

    public function render()
    {
        return view('livewire.projects.create');
    }
}
