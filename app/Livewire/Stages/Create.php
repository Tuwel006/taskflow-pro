<?php

namespace App\Livewire\Stages;

use App\Models\Stage;
use App\Models\TaskStatus;
use App\Models\Teams;
use Livewire\Component;

class Create extends Component
{
    public $team_id;

    public $status_id;

    public $position;

    public function render()
    {
        $teams = Teams::where('is_active', true)->get();
        $statuses = TaskStatus::all();

        return view('livewire.stages.create', compact('teams', 'statuses'));
    }

    public function store()
    {
        $validated = $this->validate([
            'team_id' => 'required|exists:teams,id',
            'status_id' => 'required|exists:task_statuses,id',
            'position' => 'nullable|integer|min:0',
        ]);

        if ($validated['position'] === null) {
            $nextPosition = Stage::where('team_id', $validated['team_id'])->max('position');
            $validated['position'] = $nextPosition === null ? 0 : $nextPosition + 1;
        }

        $statusExists = Stage::where('team_id', $validated['team_id'])
            ->where('status_id', $validated['status_id'])
            ->exists();

        if ($statusExists) {
            $this->addError('status_id', 'This status is already assigned to this team.');
            return;
        }

        $positionExists = Stage::where('team_id', $validated['team_id'])
            ->where('position', $validated['position'])
            ->exists();

        if ($positionExists) {
            $this->addError('position', 'Another stage already uses this position for the selected team.');
            return;
        }

        Stage::create($validated);

        session()->flash('success', 'Workflow stage created successfully');

        return $this->redirect('/workflows', navigate: true);
    }
}
