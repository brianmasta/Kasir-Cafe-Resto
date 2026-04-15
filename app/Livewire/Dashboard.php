<?php

namespace App\Livewire;

use App\Models\Table;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Dashboard extends Component
{
    public $tableName;
    public $cart = [];
    public $showReceiptModal = false;
    public $receiptData = [];

    public function mount()
    {
        if (!session()->has('table_id')) {
            $this->redirect('/', navigate: true);
            return;
        }

        $this->tableName = session('table_name');

        // 🔥 load cart per meja
        $this->cart = session('cart_' . session('table_id'), []);
    }

    public function logout()
    {
        Auth::logout();

        session()->flush(); // 🔥 clean all session

        $this->redirect('/', navigate: true);
    }

    public function backToTable()
    {
        if (session()->has('table_id')) {
            Table::find(session('table_id'))
                ?->update(['status' => 'available']);
        }

        session()->forget('table_id');
        session()->forget('table_name');

        $this->cart = [];

        $this->redirect('/tables', navigate: true);
    }

    public function addToCart($id)
    {
        $menuName = "Menu " . $id;
        $price = 10000;

        foreach ($this->cart as $key => $item) {
            if ($item['id'] == $id) {
                $this->cart[$key]['qty']++;
                $this->syncCart();
                return;
            }
        }

        $this->cart[] = [
            'id' => $id,
            'name' => $menuName,
            'price' => $price,
            'qty' => 1
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
        session()->put('cart_' . session('table_id'), $this->cart);
    }

    public function getTotalProperty()
    {
        return collect($this->cart)
            ->sum(fn($item) => $item['price'] * $item['qty']);
    }

    public function checkout()
    {
        if (empty($this->cart)) return;

        $invoice = 'INV-' . time();

        $transaction = Transaction::create([
            'invoice' => $invoice,
            'table_id' => session('table_id'),
            'user_id' => Auth::id(),
            'total' => $this->total,
        ]);

        foreach ($this->cart as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'name' => $item['name'],
                'price' => $item['price'],
                'qty' => $item['qty'],
                'subtotal' => $item['price'] * $item['qty'],
            ]);
        }

        Table::find(session('table_id'))
            ?->update(['status' => 'available']);

        // print (opsional dev mode)
        // $this->printReceipt($transaction, $this->cart);
        // $this->printKitchen($transaction, $this->cart);

        // reset cart
        $this->cart = [];
        session()->forget('cart_' . session('table_id'));

        // 🔥 TAMPILKAN MODAL (INI HARUS DI ATAS REDIRECT)
        $this->receiptData = [
            'invoice' => $transaction->invoice,
            'items' => $transaction->details()->get(),
            'total' => $transaction->total,
            'table' => session('table_name'),
        ];

        $this->showReceiptModal = true;

        session()->flash('success', 'Transaksi berhasil: ' . $invoice);

        // ❌ HAPUS REDIRECT
        // $this->redirect('/tables', navigate: true);
    }

    public function closeReceipt()
    {
        $this->showReceiptModal = false;
        $this->receiptData = [];
    }

    private function printReceipt($transaction, $items)
    {
        $connector = new WindowsPrintConnector("POS-58"); // nama printer Windows
        $printer = new Printer($connector);

        $printer->text("===== STRUK KASIR =====\n");
        $printer->text("Invoice: {$transaction->invoice}\n");
        $printer->text("Meja: " . session('table_name') . "\n");
        $printer->text("------------------------\n");

        foreach ($items as $item) {

            $subtotal = $item['qty'] * $item['price'];

            $printer->text("{$item['name']}\n");

            $printer->text(
                $item['qty'] . " x " . $item['price'] . " = " . $subtotal . "\n"
            );
        }

        $printer->text("------------------------\n");
        $printer->text("TOTAL: {$transaction->total}\n");

        $printer->text("\nTerima Kasih\n");

        $printer->cut();
        $printer->close();
    }

    private function printKitchen($transaction, $items)
    {
        $connector = new WindowsPrintConnector("POS-KITCHEN");
        $printer = new Printer($connector);

        $printer->text("===== KITCHEN ORDER =====\n");
        $printer->text("Meja: " . session('table_name') . "\n");
        $printer->text("Invoice: {$transaction->invoice}\n");
        $printer->text("------------------------\n");

        foreach ($items as $item) {
            $printer->text("{$item['name']} - {$item['qty']}\n");
        }

        $printer->text("------------------------\n");
        $printer->text("MASAK SEKARANG\n");

        $printer->cut();
        $printer->close();
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('layouts.app');
    }
}
