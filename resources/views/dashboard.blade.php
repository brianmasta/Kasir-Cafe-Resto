<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-2 text-white p-3"
             style="height:100vh; background: linear-gradient(180deg,#1e3c72,#2a5298);">

            <h4 class="mb-4">🍽️ POS</h4>

            <div class="mb-2">Dashboard</div>
            <div class="mb-2">Transaksi</div>
            <div class="mb-2">Laporan</div>

            <hr>

            <!-- LOGOUT -->
            <button wire:click="logout"
                    class="btn w-100 text-start text-white">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>

        </div>

        <!-- MAIN -->
        <div class="col-10 p-4" style="background:#f5f7fb;">

            <!-- HEADER -->
            <div class="d-flex justify-content-between mb-4">
                <h4>Dashboard Kasir</h4>

                <div>
                    👤 {{ auth()->user()->name }} |
                    🕒 {{ now()->format('H:i') }}
                </div>
            </div>

            <div class="row">

                <!-- PRODUK -->
                <div class="col-8">
                    <div class="row">
                        @for($i = 1; $i <= 8; $i++)
                        <div class="col-3 mb-3">
                            <div class="card p-3 text-center shadow-sm"
                                 style="border-radius:15px;">
                                <h6>Menu {{ $i }}</h6>
                                <p class="text-muted">Rp 10.000</p>
                                <button class="btn btn-sm btn-primary">
                                    Tambah
                                </button>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- CART -->
                <div class="col-4">
                    <div class="bg-white p-3 shadow"
                         style="border-radius:15px;">

                        <h5>🛒 Keranjang</h5>

                        <hr>

                        <p class="text-muted">Belum ada item</p>

                        <hr>

                        <h5>Total: Rp 0</h5>

                        <button class="btn btn-success w-100">
                            Checkout
                        </button>

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>