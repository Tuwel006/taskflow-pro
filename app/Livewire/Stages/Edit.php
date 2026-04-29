<?php

namespace App\Livewire\Stages;

use App\Models\Stage;
use App\Models\TaskStatus;
use App\Models\Project;
use Livewire\Component;

class Edit extends Component
{
    public $id;

    public $project_id;

    public $status_id;

    public $position;

    public function mount($id)
    {
        $stage = Stage::find($id);
        $this->id = $stage->id;
        $this->project_id = $stage->project_id;
        $this->status_id = $stage->status_id;
        $this->position = $stage->position;
    }

    public function render()
    {
        $projects = Project::where('is_active', true)->get();
        $statuses = TaskStatus::all();

        return view('livewire.stages.edit', compact('projects', 'statuses'));
    }

    public function update()
    {
        $validated = $this->validate([
            'project_id' => 'required|exists:projects,id',
            'status_id' => 'required|exists:task_statuses,id',
            'position' => 'required|integer|min:0',
        ]);

        $statusExists = Stage::where('project_id', $this->project_id)
            ->where('status_id', $this->status_id)
            ->where('id', '!=', $this->id)
            ->exists();

        if ($statusExists) {
            $this->addError('status_id', 'This status is already assigned to this project.');
            return;
        }

        $positionExists = Stage::where('project_id', $this->project_id)
            ->where('position', $this->position)
            ->where('id', '!=', $this->id)
            ->exists();

        if ($positionExists) {
            $this->addError('position', 'Another stage already uses this position for the selected project.');
            return;
        }

        $stage = Stage::find($this->id);
        $stage->project_id = $validated['project_id'];
        $stage->status_id = $validated['status_id'];
        $stage->position = $validated['position'];
        $stage->save();

        session()->flash('message', 'Workflow stage updated successfully');

        return $this->redirect('/workflows', navigate: true);
    }
}
