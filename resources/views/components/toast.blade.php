<div x-data="{ 
        messages: [],
        remove(id) {
            this.messages = this.messages.filter(m => m.id !== id)
        },
        add(data) {
            const id = Date.now()
            
            // Extract message and type from various potential formats
            let message = '';
            let type = 'success';

            if (typeof data === 'string') {
                message = data;
            } else if (Array.isArray(data)) {
                // Livewire 3 often wraps the object in an array [ { message: '...', type: '...' } ]
                const payload = data[0] || {};
                message = payload.message || '';
                type = payload.type || 'success';
            } else if (typeof data === 'object' && data !== null) {
                // Standard object { message: '...', type: '...' }
                message = data.message || '';
                type = data.type || 'success';
            }

            if (!message) return; // Don't show empty toasts

            this.messages.push({ id, text: message, type });
            setTimeout(() => this.remove(id), 5000);
        }
     }"
     @toast.window="add($event.detail)"
     class="fixed-bottom p-3 d-flex flex-column align-items-end"
     style="z-index: 9999; pointer-events: none; right: 10px; bottom: 10px;">
    
    <template x-for="msg in messages" :key="msg.id">
        <div x-show="true"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-x-full opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="translate-x-full opacity-0"
             class="d-flex align-items-center mb-2 shadow-lg border"
             :style="{
                'background': (msg.type === 'success') ? '#f0fdf4' : (msg.type === 'warning' ? '#fffbeb' : '#fef2f2'),
                'border-color': (msg.type === 'success' ? '#bbf7d0' : (msg.type === 'warning' ? '#fde68a' : '#fecaca')) + ' !important',
                'color': (msg.type === 'success' ? '#166534' : (msg.type === 'warning' ? '#92400e' : '#991b1b')),
                'min-width': '220px',
                'border-radius': '8px',
                'pointer-events': 'auto',
                'padding': '12px 16px'
             }"
             role="alert">
            
            <div class="d-flex align-items-center gap-2 flex-grow-1">
                {{-- Dynamic Icons based on Type --}}
                <template x-if="msg.type === 'success'">
                    <i class="bi bi-check2-circle fs-5"></i>
                </template>
                <template x-if="msg.type === 'warning'">
                    <i class="bi bi-exclamation-circle fs-5"></i>
                </template>
                <template x-if="msg.type === 'danger' || msg.type === 'error'">
                    <i class="bi bi-x-circle fs-5"></i>
                </template>
                
                <div class="d-flex flex-column">
                    <span x-text="msg.text" style="font-size: 0.75rem; font-weight: 600; line-height: 1.3;"></span>
                </div>
            </div>

            <button type="button" @click="remove(msg.id)" class="btn-close ms-2" style="font-size: 0.6rem; filter: grayscale(1) opacity(0.5); border: none; shadow: none;"></button>
        </div>
    </template>

    <style>
        .fixed-bottom {
            position: fixed;
            right: 0;
            bottom: 0;
            left: auto !important;
        }
    </style>
</div>
