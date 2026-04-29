<?php

namespace App\Livewire\Workflow;

use App\Models\TaskStatus;
use App\Models\Project;
use App\Models\Workflow;
use App\Models\Stage;
use Livewire\Component;

class Index extends Component
{
    public $selectedProjectId;
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
        'selectedProjectId' => 'required|exists:projects,id',
    ];

    public function mount()
    {
        $firstProject = Project::where('is_active', true)->first();
        if ($firstProject) {
            $this->selectedProjectId = $firstProject->id;
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
        $stage = Stage::where('project_id', $this->selectedProjectId)->findOrFail($id);
        $this->editingStageId = $stage->id;
        $this->stageStatusId = $stage->status_id;
        $this->stagePosition = $stage->position;
    }

    public function saveStage()
    {
        $this->validate([
            'stageStatusId' => 'required|exists:task_statuses,id',
            'stagePosition' => 'required|integer|min:0',
            'selectedProjectId' => 'required|exists:projects,id',
        ]);

        // Check if status already exists for this project (excluding current if editing)
        $exists = Stage::where('project_id', $this->selectedProjectId)
            ->where('status_id', $this->stageStatusId)
            ->when($this->editingStageId, fn($q) => $q->where('id', '!=', $this->editingStageId))
            ->exists();

        if ($exists) {
            $this->dispatch('toast', ['message' => 'This status is already assigned to this project.', 'type' => 'danger']);
            return;
        }

        if ($this->editingStageId) {
            $stage = Stage::findOrFail($this->editingStageId);
            $stage->update([
                'status_id' => $this->stageStatusId,
                'position' => $this->stagePosition,
            ]);
            $this->dispatch('toast', ['message' => 'Stage updated successfully.', 'type' => 'success']);
        } else {
            Stage::create([
                'project_id' => $this->selectedProjectId,
                'status_id' => $this->stageStatusId,
                'position' => $this->stagePosition,
            ]);
            $this->dispatch('toast', ['message' => 'Stage added successfully.', 'type' => 'success']);
        }

        $this->resetStageForm();
    }

    public function updatedSelectedProjectId()
    {
        $this->resetStageForm();
        $this->fromStatusId = null;
        $this->toStatusId = null;
    }

    public function deleteStage($id)
    {
        Stage::where('id', $id)->where('project_id', $this->selectedProjectId)->delete();
        $this->dispatch('toast', ['message' => 'Workflow stage deleted successfully.', 'type' => 'success']);
    }

    public function addTransition()
    {
        $this->validate();

        // Check for duplicates
        $exists = Workflow::where('project_id', $this->selectedProjectId)
            ->where('from_status_id', $this->fromStatusId)
            ->where('to_status_id', $this->toStatusId)
            ->exists();

        if ($exists) {
            $this->dispatch('toast', ['message' => 'This transition already exists.', 'type' => 'danger']);
            return;
        }

        Workflow::create([
            'project_id' => $this->selectedProjectId,
            'from_status_id' => $this->fromStatusId,
            'to_status_id' => $this->toStatusId,
        ]);

        $this->reset(['fromStatusId', 'toStatusId']);
        $this->dispatch('toast', ['message' => 'Transition added successfully.', 'type' => 'success']);
    }

    public function deleteTransition($id)
    {
        $workflow = Workflow::where('project_id', $this->selectedProjectId)->findOrFail($id);
        $workflow->delete();
        $this->dispatch('toast', ['message' => 'Transition removed.', 'type' => 'success']);
    }

    public function render()
    {
        $projects = Project::where('is_active', true)->get();
        
        // Get all statuses available for this project via Stages
        $stages = Stage::where('project_id', $this->selectedProjectId)
            ->with('status')
            ->when($this->search, function($query) {
                $query->whereHas('status', function($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('position')
            ->get();

        $availableStatuses = $stages->pluck('status')->filter();

        $workflows = Workflow::where('project_id', $this->selectedProjectId)
            ->with(['fromStatus', 'toStatus'])
            ->get();

        return view('livewire.workflow.index', [
            'projects' => $projects,
            'stages' => $stages,
            'availableStatuses' => $availableStatuses,
            'workflows' => $workflows,
        ]);
    }
}
