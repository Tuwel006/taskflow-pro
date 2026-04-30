<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use App\UserType;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $itemPerPage = 10;
    public $search = '';
    public $status = '';   // '' = all, '1' = active, '0' = inactive

    public function updatingItemPerPage() { $this->resetPage(); }
    public function updatingSearch()      { $this->resetPage(); }
    public function updatingStatus()      { $this->resetPage(); }

    public function render()
    {
        $users = User::with(['projects'])
            ->where('type', UserType::Agent)
            ->when($this->search, fn($q) =>
                $q->where(fn($q) =>
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                )
            )
            ->when($this->status !== '', fn($q) =>
                $q->where('is_active', (bool) $this->status)
            )
            ->paginate($this->itemPerPage);

        return view('livewire.user.index', compact('users'));
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'User deleted successfully');
    }
}
