<?php

namespace App\Livewire\Channels;

use App\Models\Channels;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $status = true;

    public $search;

    public $itemPerPage = 10;

    public function render()
    {
        $channels = Channels::where('is_active', $this->status)
            ->where('name', 'like', "%{$this->search}%")
            ->paginate($this->itemPerPage);

        return view('livewire.channels.index', compact('channels'));
    }
}
