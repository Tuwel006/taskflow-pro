<?php

namespace App\Livewire\Client;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Edit extends Component
{
    public $id;
    public $name;
    public $email;
    public $phone;
    public $address;
    public $role;
    public $password;
    public $avatar;
    public $is_active;

    public function mount($id)
    {
        $client = User::find($id);
        $this->id = $client->id;
        $this->name = $client->name;
        $this->email = $client->email;
        $this->phone = $client->phone;
        $this->address = $client->address;
        $this->role = $client->role;
        $this->avatar = $client->avatar;
        $this->is_active = $client->is_active;
    }

    public function render()
    {
        return view('livewire.client.edit');
    }

    public function update()
    {
        $client = User::find($this->id);
        $client->name = $this->name;
        $client->email = $this->email;
        $client->phone = $this->phone;
        $client->address = $this->address;
        $client->role = $this->role;
        $client->type = 2;
        $client->avatar = $this->avatar;
        $client->is_active = $this->is_active;
        if ($this->password) {
            $client->password = Hash::make($this->password);
        }
        $client->save();

        session()->flash('message', 'Client updated successfully');

        return redirect()->route('clients');
    }
}
