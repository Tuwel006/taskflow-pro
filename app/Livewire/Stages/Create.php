<?php

namespace App\Livewire\Stages;

use App\Models\Stage;
use App\Models\TaskStatus;
use App\Models\Project;
use Livewire\Component;

class Create extends Component
{
    public $project_id;

    public $status_id;

    public $position;

    public function render()
    {
        $projects = Project::where('is_active', true)->get();
        $statuses = TaskStatus::all();

        return view('livewire.stages.create', compact('projects', 'statuses'));
    }

    public function store()
    {
        $validated = $this->validate([
            'project_id' => 'required|exists:projects,id',
            'status_id' => 'required|exists:task_statuses,id',
            'position' => 'nullable|integer|min:0',
        ]);

        if ($validated['position'] === null) {
            $nextPosition = Stage::where('project_id', $validated['project_id'])->max('position');
            $validated['position'] = $nextPosition === null ? 0 : $nextPosition + 1;
        }

        $statusExists = Stage::where('project_id', $validated['project_id'])
            ->where('status_id', $validated['status_id'])
            ->exists();

        if ($statusExists) {
            $this->addError('status_id', 'This status is already assigned to this project.');
            return;
        }

        $positionExists = Stage::where('project_id', $validated['project_id'])
            ->where('position', $validated['position'])
            ->exists();

        if ($positionExists) {
            $this->addError('position', 'Another stage already uses this position for the selected project.');
            return;
        }

        Stage::create($validated);

        session()->flash('success', 'Workflow stage created successfully');

        return $this->redirect('/workflows', navigate: true);
    }
}
