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

            <!-- DINDING -->
            <div class="text-center text-muted mb-2">
                🍽️ AREA RESTORAN
            </div>

            <!-- GRID LAYOUT RESTORAN -->
            <div class="d-flex flex-wrap justify-content-center gap-3">

                @foreach($tables as $table)

                    <div style="width:110px;">

                        <button
                            wire:click="selectTable({{ $table->id }})"
                            class="btn w-100 py-3 shadow-sm fw-bold

                            @if($table->status == 'occupied')
                                btn-danger
                            @else
                                btn-success
                            @endif">

                            🪑<br>
                            {{ $table->name }}

                        </button>

                    </div>

                @endforeach

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