<?php

namespace App\Livewire\TaskTypes;

use App\Models\TaskType;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $name;

    public $description;

    public $is_active = true;

    public $icon;
    public $taskTypeId;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'editTaskType',
    ];

    protected $rules = [
        'name' => 'required|min:3',
        'description' => 'nullable',
        'is_active' => 'boolean',
        'icon' => 'nullable',
    ];

    public function render()
    {
        return view('livewire.task-types.index', [
            'taskTypes' => TaskType::paginate(10),
        ]);
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset([
            'name',
            'description',
            'is_active',
            'icon',
            'taskTypeId',
        ]);
        $this->dispatch('open-modal');
    }

    public function edit($id)
    {
        $taskType = TaskType::find($id);
        if (!$taskType) return;

        $this->taskTypeId = $taskType->id;
        $this->name = $taskType->name;
        $this->description = $taskType->description;
        $this->is_active = $taskType->is_active;
        $this->icon = $taskType->icon;
        
        $this->resetValidation();
        $this->dispatch('open-modal');
    }

    public function store()
    {
        $this->validate();

        TaskType::updateOrCreate(
            ['id' => $this->taskTypeId],
            [
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->is_active,
                'icon' => $this->icon,
            ]
        );

        $this->dispatch('close-modal');
        session()->flash('message', $this->taskTypeId ? 'Task Type updated successfully.' : 'Task Type created successfully.');
        $this->reset(['name', 'description', 'is_active', 'icon', 'taskTypeId']);
    }

    public function delete($id)
    {
        TaskType::find($id)->delete();
        session()->flash('message', 'Task Type deleted successfully.');
    }
}
