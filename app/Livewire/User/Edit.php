<?php

namespace App\Livewire\User;

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

    public $type;

    public $password;

    public $avatar;

    public $is_active;

    public function mount($id)
    {
        $user = User::find($id);
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->role = $user->role;
        $this->type = $user->type;
        $this->avatar = $user->avatar;
        $this->is_active = $user->is_active;
    }

    public function render()
    {
        return view('livewire.user.edit');
    }

    public function update()
    {
        $user = User::find($this->id);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->address = $this->address;
        $user->role = $this->role;
        $user->type = $this->type;
        $user->avatar = $this->avatar;
        $user->is_active = $this->is_active;
        if ($this->password) {
            $user->password = Hash::make($this->password);
        }
        $user->save();

        session()->flash('message', 'User updated successfully');

        return redirect()->route('users');
    }
}
