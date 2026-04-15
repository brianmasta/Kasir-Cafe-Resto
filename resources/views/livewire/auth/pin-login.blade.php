<div class="container-fluid vh-100 d-flex align-items-center justify-content-center" 
     style="background: linear-gradient(135deg, #1e3c72, #2a5298);">

    <div class="card border-0 shadow-lg" 
         style="width:420px; border-radius:20px; backdrop-filter: blur(10px);">

        <div class="card-body p-4">

            <!-- HEADER -->
            <div class="text-center mb-4">
                <div class="mb-2" style="font-size:45px;">🍽️</div>
                <h4 class="fw-bold mb-0">POS Restoran</h4>
                <small class="text-muted">Sistem Kasir Modern</small>
            </div>

            <!-- PILIH USER -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Kasir</label>

                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-person"></i>
                    </span>

                    <select wire:model="selectedUser" class="form-select">
                        <option value="">Pilih Kasir...</option>

                        @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- PIN -->
            <div class="mb-3">
                <label class="form-label fw-semibold">PIN</label>

                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-shield-lock"></i>
                    </span>

                    <input type="password"
                           wire:model="pin"
                           wire:keydown.enter="login"
                           class="form-control text-center fs-5"
                           placeholder="••••"
                           autofocus>
                </div>

                @error('pin')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>

            <!-- BUTTON -->
            <div class="d-grid mt-4">
                <button wire:click="login"
                        class="btn btn-primary fw-semibold"
                        style="border-radius:12px; padding:10px;">
                    🔐 Masuk
                </button>
            </div>

        </div>
    </div>

</div>
