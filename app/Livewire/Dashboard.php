<?php

namespace App\Livewire;

use App\Models\Menu;
use App\Models\Table;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Dashboard extends Component
{
    public $tableId;
    public $tableName;
    public $cart = [];
    public $menus = [];

    public $showReceiptModal = false;
    public $receiptData = [];

    public function mount($tableId)
    {
        $table = Table::findOrFail($tableId);

        $this->tableId = $table->id;
        $this->tableName = $table->name;

        // cart per meja
        $this->cart = session('cart_' . $this->tableId, []);

        $this->menus = Menu::where('is_active', true)->get();

        // set status meja saat mulai pakai
        $table->update(['status' => 'used']);
    }

    /* =========================
        CART SYSTEM
    ========================= */

    public function addToCart($id)
    {
        $menu = Menu::findOrFail($id);

        foreach ($this->cart as $key => $item) {
            if ($item['id'] == $id) {
                $this->cart[$key]['qty']++;
                $this->syncCart();
                return;
            }
        }

        $this->cart[] = [
            'id' => $menu->id,
            'name' => $menu->name,
            'price' => $menu->price,
            'qty' => 1,
            'category' => $menu->category,
        ];

        $this->syncCart();
    }

    public function decreaseQty($id)
    {
        foreach ($this->cart as $key => $item) {
            if ($item['id'] == $id) {

                $this->cart[$key]['qty']--;

                if ($this->cart[$key]['qty'] <= 0) {
                    unset($this->cart[$key]);
                }

                $this->cart = array_values($this->cart);
                $this->syncCart();
                return;
            }
        }
    }

    public function removeItem($id)
    {
        $this->cart = array_values(array_filter(
            $this->cart,
            fn($item) => $item['id'] != $id
        ));

        $this->syncCart();
    }

    public function syncCart()
    {
        session()->put('cart_' . $this->tableId, $this->cart);
    }

    public function getTotalProperty()
    {
        return collect($this->cart)
            ->sum(fn($item) => $item['price'] * $item['qty']);
    }

    /* =========================
        CHECKOUT
    ========================= */

    public function checkout()
    {
        if (empty($this->cart)) return;

        $invoice = 'INV-' . time();

        $transaction = Transaction::create([
            'invoice' => $invoice,
            'table_id' => $this->tableId,
            'user_id' => Auth::id(),
            'total' => $this->total,
            'status' => 'pending',
        ]);

        foreach ($this->cart as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'name' => $item['name'],
                'price' => $item['price'],
                'qty' => $item['qty'],
                'category' => $item['category'],
                'subtotal' => $item['price'] * $item['qty'],

                // KDS default
                'status' => 'pending',
            ]);
        }

        // clear cart
        $this->cart = [];
        session()->forget('cart_' . $this->tableId);

        // receipt modal
        $this->receiptData = [
            'invoice' => $transaction->invoice,
            'items' => $transaction->details()->get(),
            'total' => $transaction->total,
            'table' => $this->tableName,
        ];

        $this->showReceiptModal = true;
    }

    /* =========================
        CLOSE TABLE (PELANGGAN PULANG)
    ========================= */

    public function closeTable()
    {
        Table::find($this->tableId)
            ?->update(['status' => 'available']);

        session()->forget('cart_' . $this->tableId);

        $this->redirect('/tables', navigate: true);
    }

    public function closeReceipt()
    {
        $this->showReceiptModal = false;
        $this->receiptData = [];
    }

    /* =========================
        RENDER
    ========================= */

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('layouts.app');
    }
}
