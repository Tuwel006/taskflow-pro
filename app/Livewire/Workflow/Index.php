<?php

namespace App\Livewire\Workflow;

use App\Models\TaskStatus;
use App\Models\Teams;
use App\Models\Workflow;
use App\Models\Stage;
use Livewire\Component;

class Index extends Component
{
    public $selectedTeamId;
    public $fromStatusId;
    public $toStatusId;
    public $tab = 'stages'; // 'stages' or 'flow'
    public $search;
    public $itemPerPage = 10;

    // Stage Form Properties
    public $editingStageId;
    public $stageStatusId;
    public $stagePosition;

    protected $rules = [
        'fromStatusId' => 'required|exists:task_statuses,id',
        'toStatusId' => 'required|exists:task_statuses,id|different:fromStatusId',
        'selectedTeamId' => 'required|exists:teams,id',
    ];

    public function mount()
    {
        $firstTeam = Teams::where('is_active', true)->first();
        if ($firstTeam) {
            $this->selectedTeamId = $firstTeam->id;
        }
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
        $this->resetStageForm();
        $this->fromStatusId = null;
        $this->toStatusId = null;
    }

    public function resetStageForm()
    {
        $this->reset(['editingStageId', 'stageStatusId', 'stagePosition']);
    }

    public function editStage($id)
    {
        $stage = Stage::where('team_id', $this->selectedTeamId)->findOrFail($id);
        $this->editingStageId = $stage->id;
        $this->stageStatusId = $stage->status_id;
        $this->stagePosition = $stage->position;
    }

    public function saveStage()
    {
        $this->validate([
            'stageStatusId' => 'required|exists:task_statuses,id',
            'stagePosition' => 'required|integer|min:0',
            'selectedTeamId' => 'required|exists:teams,id',
        ]);

        // Check if status already exists for this team (excluding current if editing)
        $exists = Stage::where('team_id', $this->selectedTeamId)
            ->where('status_id', $this->stageStatusId)
            ->when($this->editingStageId, fn($q) => $q->where('id', '!=', $this->editingStageId))
            ->exists();

        if ($exists) {
            session()->flash('error', 'This status is already assigned to this team.');
            return;
        }

        if ($this->editingStageId) {
            $stage = Stage::findOrFail($this->editingStageId);
            $stage->update([
                'status_id' => $this->stageStatusId,
                'position' => $this->stagePosition,
            ]);
            session()->flash('success', 'Stage updated successfully.');
        } else {
            Stage::create([
                'team_id' => $this->selectedTeamId,
                'status_id' => $this->stageStatusId,
                'position' => $this->stagePosition,
            ]);
            session()->flash('success', 'Stage added successfully.');
        }

        $this->resetStageForm();
    }

    public function updatedSelectedTeamId()
    {
        $this->resetStageForm();
        $this->fromStatusId = null;
        $this->toStatusId = null;
    }

    public function deleteStage($id)
    {
        Stage::where('id', $id)->where('team_id', $this->selectedTeamId)->delete();
        session()->flash('success', 'Workflow stage deleted successfully.');
    }

    public function addTransition()
    {
        $this->validate();

        // Check for duplicates
        $exists = Workflow::where('team_id', $this->selectedTeamId)
            ->where('from_status_id', $this->fromStatusId)
            ->where('to_status_id', $this->toStatusId)
            ->exists();

        if ($exists) {
            session()->flash('error', 'This transition already exists.');
            return;
        }

        Workflow::create([
            'team_id' => $this->selectedTeamId,
            'from_status_id' => $this->fromStatusId,
            'to_status_id' => $this->toStatusId,
        ]);

        $this->reset(['fromStatusId', 'toStatusId']);
        session()->flash('success', 'Transition added successfully.');
    }

    public function deleteTransition($id)
    {
        $workflow = Workflow::where('team_id', $this->selectedTeamId)->findOrFail($id);
        $workflow->delete();
        session()->flash('success', 'Transition removed.');
    }

    public function render()
    {
        $teams = Teams::where('is_active', true)->get();
        
        // Get all statuses available for this team via Stages
        $stages = Stage::where('team_id', $this->selectedTeamId)
            ->with('status')
            ->when($this->search, function($query) {
                $query->whereHas('status', function($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('position')
            ->get();

        $availableStatuses = $stages->pluck('status')->filter();

        $workflows = Workflow::where('team_id', $this->selectedTeamId)
            ->with(['fromStatus', 'toStatus'])
            ->get();

        return view('livewire.workflow.index', [
            'teams' => $teams,
            'stages' => $stages,
            'availableStatuses' => $availableStatuses,
            'workflows' => $workflows,
        ]);
    }
}
