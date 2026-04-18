<div>

    <!-- FORM INPUT -->
    <div class="card p-4 mb-4 shadow-sm" style="border-radius:15px;">
        <h5>{{ $editId ? 'Edit Menu' : 'Tambah Menu' }}</h5>

        <div class="row">
            <div class="col-md-4 mb-2">
                <input type="text" wire:model="name"
                       class="form-control"
                       placeholder="Nama Menu">
            </div>

            <div class="col-md-3 mb-2">
                <input type="number" wire:model="price"
                       class="form-control"
                       placeholder="Harga">
            </div>

            <div class="col-md-3 mb-2">
                <select wire:model="category" class="form-select">
                    <option value="">Kategori</option>
                    <option value="food">Makanan</option>
                    <option value="drink">Minuman</option>
                </select>
            </div>

            <div class="col-md-2 mb-2">
                <button wire:click="save"
                        class="btn btn-primary w-100">
                    💾 Simpan
                </button>
            </div>
        </div>
    </div>

    <!-- LIST MENU -->
    <div class="card p-3 shadow-sm" style="border-radius:15px;">

        <h5 class="mb-3">📋 Daftar Menu</h5>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($menus as $menu)
                <tr>
                    <td>{{ $menu->name }}</td>
                    <td>Rp {{ number_format($menu->price) }}</td>
                    <td>
                        @if($menu->category == 'food')
                            🍽️ Makanan
                        @else
                            🧃 Minuman
                        @endif
                    </td>
                    <td>
                        <button wire:click="edit({{ $menu->id }})"
                                class="btn btn-sm btn-warning">
                            Edit
                        </button>

                        <button wire:click="delete({{ $menu->id }})"
                                class="btn btn-sm btn-danger">
                            Hapus
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>
