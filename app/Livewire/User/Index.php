<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Project;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $itemPerPage = 10;
    public $search = '';
    public $selectedProjectId = '';

    public function mount()
    {
        $this->selectedProjectId = session('selected_project_id', '');
    }

    public function updatingItemPerPage()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedProjectId($value)
    {
        session(['selected_project_id' => $value]);
        $this->resetPage();
    }

    public function render()
    {
        $projects = Project::where('is_active', true)->get();
        $users = User::with(['projects'])
            ->when($this->selectedProjectId, function($query) {
                $query->whereHas('projects', function($q) {
                    $q->where('projects.id', $this->selectedProjectId);
                });
            })
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            })->paginate($this->itemPerPage);
        return view('livewire.user.index', compact('users', 'projects'));
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        session()->flash('message', 'User deleted successfully');
    }
}
