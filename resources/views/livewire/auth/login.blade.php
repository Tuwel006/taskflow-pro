<div>
    <!-- Logo/Brand Header -->
    <div class="text-center mb-4">
        <div class="d-inline-flex align-items-center justify-content-center bg-dark text-white rounded-circle shadow-sm mb-3" 
             style="width: 54px; height: 54px; border: 2px solid #334155;">
            <i class="bi bi-shield-lock-fill" style="font-size: 1.5rem;"></i>
        </div>
        <h4 class="fw-bold mb-1" style="letter-spacing: -0.02em; color: #0f172a;">TaskFlow Registry</h4>
        <p class="text-muted small">Professional Task Management Console</p>
    </div>

    <!-- Login Card -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <div class="card-body p-4 p-md-5">
            <h5 class="fw-bold mb-4" style="color: #1e293b;">Sign In</h5>
            
            <form wire:submit.prevent="authenticate">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted" style="font-size: 0.75rem;">EMAIL ADDRESS</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                        <input type="email" wire:model="email" class="form-control border-start-0" placeholder="name@company.com" style="font-size: 0.875rem; border-radius: 0 6px 6px 0;">
                    </div>
                    @error('email') <div class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-semibold text-muted mb-0" style="font-size: 0.75rem;">PASSWORD</label>
                        <a href="#" class="text-decoration-none" style="font-size: 0.7rem; font-weight: 600; color: #3b82f6;">Forgot?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-key"></i></span>
                        <input type="password" wire:model="password" class="form-control border-start-0" placeholder="••••••••" style="font-size: 0.875rem; border-radius: 0 6px 6px 0;">
                    </div>
                    @error('password') <div class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label text-muted ms-1" for="rememberMe" style="font-size: 0.8125rem;">
                        Keep me signed in for 30 days
                    </label>
                </div>

                <button type="submit" class="btn btn-dark w-100 py-2 fw-bold position-relative shadow-sm" 
                        style="border-radius: 8px; background: #0f172a; border: none; font-size: 0.875rem;">
                    <span wire:loading.remove wire:target="authenticate">Access Workspace</span>
                    <span wire:loading wire:target="authenticate">
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span> Authenticating...
                    </span>
                    <i class="bi bi-arrow-right ms-2" wire:loading.remove wire:target="authenticate"></i>
                </button>
            </form>

            @if (session()->has('error'))
                <div class="alert alert-danger border-0 mt-4 d-flex align-items-center" role="alert" style="font-size: 0.8125rem; border-radius: 8px;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer Security Notice -->
    <div class="text-center mt-5">
        <p class="text-muted" style="font-size: 0.7rem;">
            <i class="bi bi-lock me-1"></i> AES-256 Encrypted Session Connection
        </p>
        <div class="d-flex justify-content-center gap-3 mt-2" style="font-size: 0.75rem;">
            <a href="#" class="text-muted text-decoration-none">Privacy Policy</a>
            <span class="text-muted opacity-25">|</span>
            <a href="#" class="text-muted text-decoration-none">System Status</a>
        </div>
    </div>
</div>
