<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class Edit extends Component
{
    public $projectId;
    public $name;
    public $prefix;
    public $description;
    public $is_active;

    public function mount($id)
    {
        $project = Project::findOrFail($id);
        $this->projectId = $project->id;
        $this->name = $project->name;
        $this->prefix = $project->prefix;
        $this->description = $project->description;
        $this->is_active = (bool) $project->is_active;
    }

    protected function rules()
    {
        return [
            'name' => 'required|min:3|unique:projects,name,' . $this->projectId,
            'prefix' => 'required|min:2|max:5|unique:projects,prefix,' . $this->projectId,
            'description' => 'nullable|string',
        ];
    }

    public function update()
    {
        $this->validate();

        $project = Project::findOrFail($this->projectId);
        $project->update([
            'name' => $this->name,
            'prefix' => strtoupper($this->prefix),
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        $this->dispatch('toast', ['message' => 'Project updated successfully!', 'type' => 'success']);

        return $this->redirect('/projects', navigate: true);
    }

    public function render()
    {
        return view('livewire.projects.edit');
    }
}
