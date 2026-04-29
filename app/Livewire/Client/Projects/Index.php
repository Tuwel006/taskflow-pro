<?php

namespace App\Livewire\Client\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $itemPerPage = 10;

    public function render()
    {
        // Clients only see projects they are explicitly assigned to
        $projects = auth()->user()->projects()
            ->where('is_active', true)
            ->where('name', 'like', "%{$this->search}%")
            ->paginate($this->itemPerPage);

        return view('livewire.client.projects.index', compact('projects'))
            ->layout('components.layouts.client');
    }
}
