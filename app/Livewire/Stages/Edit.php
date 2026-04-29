<?php

namespace App\Livewire\Stages;

use App\Models\Stage;
use App\Models\TaskStatus;
use App\Models\Teams;
use Livewire\Component;

class Edit extends Component
{
    public $id;

    public $team_id;

    public $status_id;

    public $position;

    public function mount($id)
    {
        $stage = Stage::find($id);
        $this->id = $stage->id;
        $this->team_id = $stage->team_id;
        $this->status_id = $stage->status_id;
        $this->position = $stage->position;
    }

    public function render()
    {
        $teams = Teams::where('is_active', true)->get();
        $statuses = TaskStatus::all();

        return view('livewire.stages.edit', compact('teams', 'statuses'));
    }

    public function update()
    {
        $validated = $this->validate([
            'team_id' => 'required|exists:teams,id',
            'status_id' => 'required|exists:task_statuses,id',
            'position' => 'required|integer|min:0',
        ]);

        $statusExists = Stage::where('team_id', $this->team_id)
            ->where('status_id', $this->status_id)
            ->where('id', '!=', $this->id)
            ->exists();

        if ($statusExists) {
            $this->addError('status_id', 'This status is already assigned to this team.');
            return;
        }

        $positionExists = Stage::where('team_id', $this->team_id)
            ->where('position', $this->position)
            ->where('id', '!=', $this->id)
            ->exists();

        if ($positionExists) {
            $this->addError('position', 'Another stage already uses this position for the selected team.');
            return;
        }

        $stage = Stage::find($this->id);
        $stage->team_id = $validated['team_id'];
        $stage->status_id = $validated['status_id'];
        $stage->position = $validated['position'];
        $stage->save();

        session()->flash('message', 'Workflow stage updated successfully');

        return $this->redirect('/stages', navigate: true);
    }
}
