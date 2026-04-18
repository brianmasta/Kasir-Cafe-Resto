<div>

    <div class="alert alert-info mb-3">
    🪑 Meja: <strong>{{ $tableName }}</strong>
    <button wire:click="backToTable"
        class="btn btn-warning btn-sm">
    🔙 Ganti Meja
</button>
</div>
    <!-- STAT CARDS -->
    <div class="row mb-4">

        <div class="col-md-4 mb-2">
            <div class="card p-3 shadow-sm">
                <h6>Penjualan Hari Ini</h6>
                <h4 class="text-primary mb-0">Rp 0</h4>
            </div>
        </div>

        <div class="col-md-4 mb-2">
            <div class="card p-3 shadow-sm">
                <h6>Total Transaksi</h6>
                <h4 class="text-success mb-0">0</h4>
            </div>
        </div>

        <div class="col-md-4 mb-2">
            <div class="card p-3 shadow-sm">
                <h6>Menu Terjual</h6>
                <h4 class="text-warning mb-0">0</h4>
            </div>
        </div>

    </div>

    <!-- CONTENT -->
    <div class="row">

        <!-- PRODUK -->
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="mb-0">🍔 Menu Produk</h5>

                <input type="text"
                       class="form-control w-50"
                       placeholder="Cari menu...">

            </div>

            <div class="row">

                @foreach($menus as $menu)
                <div class="col-md-3 mb-3">

                    <div class="card p-3 text-center shadow-sm"
                        style="border-radius:15px; cursor:pointer;">

                        <div style="font-size:30px;">🍽️</div>

                        <h6 class="mt-2 mb-1">{{ $menu->name }}</h6>

                        <small class="text-muted">
                            Rp {{ number_format($menu->price) }}
                        </small>

                        <button wire:click="addToCart({{ $menu->id }})"
                                class="btn btn-sm btn-primary mt-2 w-100">
                            + Tambah
                        </button>

                    </div>

                </div>
                @endforeach

            </div>

        </div>

        <!-- CART -->
        <div class="col-lg-4">

            <div class="card shadow-sm p-3" style="border-radius:15px;">

                <h5>🛒 Keranjang</h5>

                <hr>

                @if(empty($cart))
                    <div class="text-center text-muted py-4">
                        Cart kosong
                    </div>
                @else

                    @foreach($cart as $item)
                        <div class="mb-3 border-bottom pb-2">

                            <div class="d-flex justify-content-between">
                                <strong>{{ $item['name'] }}</strong>

                                <button wire:click="removeItem({{ $item['id'] }})"
                                        class="btn btn-sm btn-danger">
                                    x
                                </button>
                            </div>

                            <small class="text-muted">
                                Rp {{ number_format($item['price']) }}
                            </small>

                            <div class="d-flex align-items-center gap-2 mt-2">

                                <button wire:click="decreaseQty({{ $item['id'] }})"
                                        class="btn btn-sm btn-warning">-</button>

                                <span>{{ $item['qty'] }}</span>

                                <button wire:click="addToCart({{ $item['id'] }})"
                                        class="btn btn-sm btn-success">+</button>

                                <span class="ms-auto">
                                    Rp {{ number_format($item['qty'] * $item['price']) }}
                                </span>

                            </div>

                        </div>
                    @endforeach

                @endif

                <hr>

                <div class="d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong>Rp {{ number_format($this->total) }}</strong>
                </div>

                <button wire:click="checkout"
                        class="btn btn-success w-100 mt-3">
                    💳 Checkout
                </button>

            </div>

        </div>

    </div>

    @if($showReceiptModal)
    <div class="modal fade show d-block"
        style="background:rgba(0,0,0,0.5);">

        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content p-3">

                <h5 class="text-center">🧾 STRUK</h5>

                <hr>

                <div>
                    <strong>Invoice:</strong> {{ $receiptData['invoice'] ?? '' }} <br>
                    <strong>Meja:</strong> {{ $receiptData['table'] ?? '' }}
                </div>

                <hr>

                @foreach($receiptData['items'] ?? [] as $item)
                    <div>
                        {{ $item['name'] ?? $item->name }} <br>
                        {{ $item['qty'] ?? 0 }} x {{ $item['price'] ?? 0 }}
                    </div>
                @endforeach

                <hr>

                <h5>Total: Rp {{ number_format($receiptData['total'] ?? 0) }}</h5>

                <div class="d-grid mt-3">

                    <button onclick="window.print()"
                            class="btn btn-primary mb-2">
                        🖨️ Print
                    </button>

                    <!-- CLOSE BUTTON FIX -->
                    <button wire:click="closeReceipt"
                            class="btn btn-secondary">
                        Tutup
                    </button>

                </div>

            </div>
        </div>

    </div>
    @endif

<script>
    Livewire.on('close-receipt', () => {
        setTimeout(() => {
            @this.set('showReceiptModal', false);
            window.location.href = '/tables';
        }, 2000);
    });
</script>

</div>