<div>

    <style>
        .table-btn {
            transition: all 0.2s ease;
        }

        .table-btn:hover {
            transform: scale(1.05);
        }

        .table-btn:active {
            transform: scale(0.95);
        }
    </style>

    <!-- 🔵 MAIN CONTAINER -->
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center"
        style="background: linear-gradient(135deg,#1e3c72,#2a5298);">

        <div class="card p-4 shadow"
            style="width:700px; border-radius:20px;">

            <!-- TITLE -->
            <div class="text-center mb-4">
                <h4 class="mb-0">🪑 Floor Plan Restoran</h4>
                <small class="text-muted">Pilih meja sesuai posisi restoran</small>
            </div>

            <!-- FLOOR AREA -->
            <div class="position-relative p-4"
                style="background:#f8f9fa; border-radius:15px; height:450px;">

                <div class="text-center text-muted mb-3">
                    🍽️ AREA RESTORAN
                </div>

                <!-- 🔥 LOADING KECIL -->
                <div wire:loading wire:target="selectTable"
                     class="text-center text-muted mb-2">
                    Memilih meja...
                </div>

                <!-- GRID -->
                <div class="d-flex flex-wrap justify-content-center gap-3">

                    @forelse($tables as $table)

                        <div style="width:110px;">

                            <button
                                wire:click="selectTable({{ $table->id }})"
                                wire:loading.attr="disabled"
                                wire:target="selectTable"
                                @if($table->status == 'used') disabled @endif
                                class="btn table-btn w-100 py-3 shadow-sm fw-bold
                                {{ $table->status == 'used' ? 'btn-danger' : 'btn-success' }}">

                                <span wire:loading.remove wire:target="selectTable">
                                    🪑<br>
                                    {{ $table->name }}
                                </span>

                                <span wire:loading wire:target="selectTable">
                                    <span class="spinner-border spinner-border-sm"></span>
                                </span>

                                <small class="d-block mt-1">
                                    {{ $table->status == 'used' ? 'Terpakai' : 'Kosong' }}
                                </small>

                            </button>
<button
    wire:click="toggleTableStatus({{ $table->id }})"
    class="btn btn-sm btn-secondary mt-2 w-100">

    🔄 Ubah Status
</button>
                        </div>

                    @empty

                        <div class="text-center text-muted">
                            Tidak ada meja tersedia
                        </div>

                    @endforelse
                    

                </div>

                <!-- AREA KASIR -->
                <div class="position-absolute bottom-0 end-0 m-3">
                    <div class="badge bg-dark p-2">
                        👨‍🍳 Kasir Area
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
