<?php

namespace App\Livewire\Stages;

use App\Models\Stage;
use App\Models\Teams;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $team_id;

    public $search;

    public $itemPerPage = 10;

    public function mount()
    {
        $firstTeam = Teams::where('is_active', true)->first();
        $this->team_id = $firstTeam->id ?? null;
    }

    public function render()
    {
        $teams = Teams::where('is_active', true)->get();
        
        $stages = Stage::where('team_id', $this->team_id)
            ->whereHas('status', function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->orderBy('position')
            ->paginate($this->itemPerPage);

        return view('livewire.stages.index', compact('stages', 'teams'));
    }

    public function delete($id)
    {
        Stage::where('id', $id)->delete();
        session()->flash('message', 'Workflow stage deleted successfully.');
    }
}
