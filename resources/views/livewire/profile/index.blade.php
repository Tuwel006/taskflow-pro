<div class="container-fluid py-2">

    {{-- Page Header --}}
    <x-page-header title="My Profile" subtitle="Manage your personal information and account settings"
        :breadcrumbItems="[['label' => 'Profile', 'url' => '/profile'], ['label' => 'Settings']]" />

    <style>
        /* ─── Profile Page Styles ─── */
        .profile-cover {
            height: 140px;
            background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 50%, #0f172a 100%);
            border-radius: 12px 12px 0 0;
            position: relative;
            overflow: hidden;
        }

        .profile-cover::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='28'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .profile-card-wrap {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(15, 23, 42, .06);
        }

        .profile-header-body {
            padding: 0 2rem 1.5rem;
            display: flex;
            align-items: flex-end;
            gap: 1.25rem;
            margin-top: -44px;
            flex-wrap: wrap;
        }

        .avatar-ring {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 0 0 2px #e0f2fe, 0 4px 12px rgba(14, 165, 233, .25);
            background: #e0f2fe;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: #0369a1;
            overflow: hidden;
            flex-shrink: 0;
            position: relative;
            cursor: pointer;
        }

        .avatar-ring img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, .45);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity .2s;
            border-radius: 50%;
            color: #fff;
            font-size: 1.1rem;
        }

        .avatar-ring:hover .avatar-overlay {
            opacity: 1;
        }

        .profile-meta {
            padding-top: 44px;
        }

        .profile-name {
            font-size: 1.15rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .profile-role-badge {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            background: #e0f2fe;
            color: #0369a1;
        }

        .profile-email-sm {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 4px;
        }

        /* Tabs */
        .profile-tabs {
            border-bottom: 1px solid #f1f5f9;
            padding: 0 2rem;
            display: flex;
            gap: 0;
        }

        .profile-tab-btn {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #64748b;
            padding: 0.75rem 1.1rem;
            border: none;
            background: none;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            transition: all .2s;
            display: flex;
            align-items: center;
            gap: .45rem;
        }

        .profile-tab-btn:hover {
            color: #0ea5e9;
        }

        .profile-tab-btn.active {
            color: #0369a1;
            border-bottom-color: #0ea5e9;
        }

        /* Form fields */
        .profile-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: .75rem;
            padding-bottom: .4rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .form-label-sm {
            font-size: 0.78rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: .3rem;
        }

        .form-control-profile {
            font-size: 0.8125rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: .5rem .8rem;
            color: #0f172a;
            background: #f8fafc;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control-profile:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, .12);
            background: #fff;
            outline: none;
        }

        .form-control-profile.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .1);
        }

        /* Save button */
        .btn-profile-save {
            font-size: 0.8125rem;
            font-weight: 600;
            background: linear-gradient(135deg, #0ea5e9, #0369a1);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: .5rem 1.4rem;
            transition: opacity .2s, transform .15s;
        }

        .btn-profile-save:hover {
            opacity: .9;
            transform: translateY(-1px);
        }

        .btn-profile-save:active {
            transform: translateY(0);
        }

        /* Info card */
        .info-tile {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 1rem 1.1rem;
            display: flex;
            align-items: center;
            gap: .85rem;
        }

        .info-tile .tile-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #e0f2fe;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #0369a1;
            flex-shrink: 0;
        }

        .info-tile .tile-label {
            font-size: 0.68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #94a3b8;
        }

        .info-tile .tile-value {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #0f172a;
            margin-top: 1px;
        }

        /* Success alert */
        .alert-success-profile {
            font-size: 0.8rem;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
            border-radius: 8px;
            padding: .5rem .9rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
    </style>

    <div class="profile-card-wrap mt-2">

        {{-- Cover --}}
        <div class="profile-cover"></div>

        {{-- Header with Avatar --}}
        <div class="profile-header-body">
            {{-- Avatar --}}
            <label for="avatarInput" class="avatar-ring mb-0" title="Change photo">
                @if ($avatarPreview)
                    <img src="{{ $avatarPreview }}" alt="Preview">
                @elseif ($user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}">
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
                <div class="avatar-overlay"><i class="bi bi-camera-fill"></i></div>
            </label>
            <input id="avatarInput" type="file" wire:model="avatar" accept="image/*" class="d-none">

            {{-- Name / Role --}}
            <div class="profile-meta">
                <div class="profile-name">{{ $user->name }}</div>
                <div class="d-flex align-items-center gap-2 flex-wrap mt-1">
                    <span class="profile-role-badge">
                        <i class="bi bi-shield-check me-1"></i>{{ ucfirst($user->role ?? 'Member') }}
                    </span>
                    @if ($user->is_active)
                        <span class="badge"
                            style="font-size:.68rem; background:#dcfce7; color:#15803d; border-radius:20px; padding:.2rem .6rem;">
                            <i class="bi bi-circle-fill me-1" style="font-size:.4rem; vertical-align:middle;"></i>Active
                        </span>
                    @endif
                </div>
                <div class="profile-email-sm"><i class="bi bi-envelope me-1"></i>{{ $user->email }}</div>
            </div>

            {{-- Quick stats --}}
            <div class="ms-auto d-flex gap-2 flex-wrap" style="padding-top:44px;">
                <div class="info-tile">
                    <div class="tile-icon"><i class="bi bi-calendar-event"></i></div>
                    <div>
                        <div class="tile-label">Member Since</div>
                        <div class="tile-value">{{ $user->created_at->format('M Y') }}</div>
                    </div>
                </div>
                <div class="info-tile">
                    <div class="tile-icon"><i class="bi bi-person-badge"></i></div>
                    <div>
                        <div class="tile-label">Account Type</div>
                        <div class="tile-value">{{ $user->type?->name ?? 'Standard' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="profile-tabs">
            <button class="profile-tab-btn {{ $activeTab === 'profile' ? 'active' : '' }}"
                wire:click="$set('activeTab', 'profile')">
                <i class="bi bi-person"></i> Profile Info
            </button>
            <button class="profile-tab-btn {{ $activeTab === 'security' ? 'active' : '' }}"
                wire:click="$set('activeTab', 'security')">
                <i class="bi bi-lock"></i> Security
            </button>
        </div>

        {{-- Tab Content --}}
        <div class="p-4">

            {{-- ──── Profile Tab ──── --}}
            @if ($activeTab === 'profile')
                <form wire:submit.prevent="saveProfile">

                    @if ($saveSuccess)
                        <div class="alert-success-profile mb-3" wire:init="$set('saveSuccess', false)">
                            <i class="bi bi-check-circle-fill"></i>
                            Profile updated successfully!
                        </div>
                    @endif

                    {{-- Avatar upload feedback --}}
                    @if ($avatarPreview)
                        <div class="alert-success-profile mb-3"
                            style="background:#eff6ff; border-color:#bfdbfe; color:#1d4ed8;">
                            <i class="bi bi-image"></i>
                            New photo selected. Save to apply changes.
                        </div>
                    @endif
                    @error('avatar')
                        <div class="alert-success-profile mb-3"
                            style="background:#fef2f2; border-color:#fecaca; color:#dc2626;">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror

                    {{-- Personal Information --}}
                    <div class="profile-section-title mb-3">Personal Information</div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-sm">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"
                                    style="border-color:#e2e8f0; border-radius:8px 0 0 8px;">
                                    <i class="bi bi-person text-muted"></i>
                                </span>
                                <input type="text" wire:model.defer="name"
                                    class="form-control-profile form-control @error('name') is-invalid @enderror"
                                    style="border-radius:0 8px 8px 0;" placeholder="Your full name">
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block" style="font-size:.75rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-sm">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"
                                    style="border-color:#e2e8f0; border-radius:8px 0 0 8px;">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input type="email" wire:model.defer="email"
                                    class="form-control-profile form-control @error('email') is-invalid @enderror"
                                    style="border-radius:0 8px 8px 0;" placeholder="you@example.com">
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block" style="font-size:.75rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-sm">Phone Number</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"
                                    style="border-color:#e2e8f0; border-radius:8px 0 0 8px;">
                                    <i class="bi bi-telephone text-muted"></i>
                                </span>
                                <input type="text" wire:model.defer="phone"
                                    class="form-control-profile form-control @error('phone') is-invalid @enderror"
                                    style="border-radius:0 8px 8px 0;" placeholder="+1 (555) 000-0000">
                            </div>
                            @error('phone')
                                <div class="invalid-feedback d-block" style="font-size:.75rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-sm">Role</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"
                                    style="border-color:#e2e8f0; border-radius:8px 0 0 8px;">
                                    <i class="bi bi-briefcase text-muted"></i>
                                </span>
                                <input type="text" class="form-control-profile form-control"
                                    style="border-radius:0 8px 8px 0; background:#f1f5f9; cursor:not-allowed;"
                                    value="{{ ucfirst($user->role ?? '—') }}" readonly>
                            </div>
                            <div style="font-size:.72rem; color:#94a3b8; margin-top:.3rem;">
                                <i class="bi bi-lock-fill me-1"></i>Role is managed by an administrator
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label-sm">Address</label>
                            <div class="input-group input-group-sm align-items-start">
                                <span class="input-group-text bg-white"
                                    style="border-color:#e2e8f0; border-radius:8px 0 0 8px; padding-top:.5rem;">
                                    <i class="bi bi-geo-alt text-muted"></i>
                                </span>
                                <textarea wire:model.defer="address" rows="2"
                                    class="form-control-profile form-control @error('address') is-invalid @enderror"
                                    style="border-radius:0 8px 8px 0; resize:none;" placeholder="123 Main St, City, Country"></textarea>
                            </div>
                            @error('address')
                                <div class="invalid-feedback d-block" style="font-size:.75rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" class="btn-profile-save">
                            <span wire:loading.remove wire:target="saveProfile">
                                <i class="bi bi-check2 me-1"></i>Save Changes
                            </span>
                            <span wire:loading wire:target="saveProfile">
                                <span class="spinner-border spinner-border-sm me-1"></span>Saving…
                            </span>
                        </button>
                        <button type="button" class="btn btn-sm text-muted"
                            style="font-size:.8rem; border:1px solid #e2e8f0; border-radius:8px; padding:.45rem 1rem;"
                            wire:click="mount">
                            Reset
                        </button>
                    </div>
                </form>
            @endif

            {{-- ──── Security Tab ──── --}}
            @if ($activeTab === 'security')
                <form wire:submit.prevent="savePassword">

                    @if ($passwordSuccess)
                        <div class="alert-success-profile mb-3">
                            <i class="bi bi-check-circle-fill"></i>
                            Password changed successfully!
                        </div>
                    @endif

                    <div class="profile-section-title mb-3">Change Password</div>

                    <div class="row g-3" style="max-width: 540px;">
                        <div class="col-12">
                            <label class="form-label-sm">Current Password <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"
                                    style="border-color:#e2e8f0; border-radius:8px 0 0 8px;">
                                    <i class="bi bi-lock text-muted"></i>
                                </span>
                                <input type="password" wire:model.defer="current_password"
                                    class="form-control-profile form-control @error('current_password') is-invalid @enderror"
                                    style="border-radius:0 8px 8px 0;" placeholder="Enter current password">
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback d-block" style="font-size:.75rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label-sm">New Password <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"
                                    style="border-color:#e2e8f0; border-radius:8px 0 0 8px;">
                                    <i class="bi bi-key text-muted"></i>
                                </span>
                                <input type="password" wire:model.defer="password"
                                    class="form-control-profile form-control @error('password') is-invalid @enderror"
                                    style="border-radius:0 8px 8px 0;" placeholder="Min 8 characters">
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block" style="font-size:.75rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label-sm">Confirm New Password <span
                                    class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"
                                    style="border-color:#e2e8f0; border-radius:8px 0 0 8px;">
                                    <i class="bi bi-key-fill text-muted"></i>
                                </span>
                                <input type="password" wire:model.defer="password_confirmation"
                                    class="form-control-profile form-control @error('password_confirmation') is-invalid @enderror"
                                    style="border-radius:0 8px 8px 0;" placeholder="Repeat new password">
                            </div>
                        </div>

                        <div class="col-12 mt-1">
                            <div class="p-3"
                                style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; font-size:.78rem; color:#64748b;">
                                <div class="fw-600 mb-1" style="color:#0f172a; font-weight:600;">Password requirements
                                </div>
                                <ul class="mb-0 ps-3" style="line-height:1.8;">
                                    <li>At least 8 characters long</li>
                                    <li>Contains uppercase and lowercase letters</li>
                                    <li>Contains at least one number</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn-profile-save">
                                <span wire:loading.remove wire:target="savePassword">
                                    <i class="bi bi-shield-lock me-1"></i>Update Password
                                </span>
                                <span wire:loading wire:target="savePassword">
                                    <span class="spinner-border spinner-border-sm me-1"></span>Updating…
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            @endif

        </div>
    </div>

</div>
