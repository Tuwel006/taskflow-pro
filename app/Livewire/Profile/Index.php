<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    // Profile fields
    public $name;
    public $email;
    public $phone;
    public $address;
    public $role;

    // Password fields
    public $current_password;
    public $password;
    public $password_confirmation;

    // Avatar
    public $avatar;
    public $avatarPreview;

    // UI state
    public $activeTab = 'profile';
    public $saveSuccess = false;
    public $passwordSuccess = false;

    public function mount()
    {
        $user = Auth::user();
        $this->name    = $user->name;
        $this->email   = $user->email;
        $this->phone   = $user->phone;
        $this->address = $user->address;
        $this->role    = $user->role;
    }

    public function saveProfile()
    {
        $user = Auth::user();

        $this->validate([
            'name'    => 'required|string|max:100',
            'email'   => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'   => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
        ]);

        $data = [
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'address' => $this->address,
        ];

        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        $this->saveSuccess = true;
        $this->avatar = null;

        $this->dispatch('profile-updated');
    }

    public function savePassword()
    {
        $this->validate([
            'current_password'      => 'required',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        if (! Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'The current password is incorrect.');
            return;
        }

        $user->update(['password' => Hash::make($this->password)]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->passwordSuccess = true;
    }

    public function updatedAvatar()
    {
        $this->validate(
            ['avatar' => 'image|max:10240'],
            ['avatar.max' => 'The photo must not be larger than 10MB.']
        );
        $this->avatarPreview = $this->avatar->temporaryUrl();
    }

    public function render()
    {
        $user   = Auth::user();
        $layout = $user->type === \App\UserType::Client
            ? 'components.layouts.client'
            : 'components.layouts.app';

        return view('livewire.profile.index', ['user' => $user])
            ->layout($layout);
    }
}
