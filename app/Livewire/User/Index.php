<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Teams;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $itemPerPage = 10;
    public $search = '';
    public $selectedTeamId = '';

    public function updatingItemPerPage()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedTeamId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $teams = Teams::where('is_active', true)->get();
        $users = User::with(['teams'])
            ->when($this->selectedTeamId, function($query) {
                $query->whereHas('teams', function($q) {
                    $q->where('teams.id', $this->selectedTeamId);
                });
            })
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            })->paginate($this->itemPerPage);
        return view('livewire.user.index', compact('users', 'teams'));
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        session()->flash('message', 'User deleted successfully');
    }
}
