<?php

namespace App\Livewire;

use App\Models\Table;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SelectTable extends Component
{
 
    public $selectedTable = null;
    
    public function mount()
    {
        if (!auth()->check()) {
            $this->redirect('/', navigate: true);
            return;
        }
    }

    public function selectTable($id)
    {
        $table = Table::findOrFail($id);

        if ($table->status !== 'available') {
            return;
        }

        // simpan state livewire
        $this->selectedTable = $table;

        // update database
        $table->update([
            'status' => 'used'
        ]);

        // redirect tanpa session
        return redirect('/dashboard/' . $table->id);
    }

    public function closeTable()
    {
        $tableId = session('table_id');

        // dd($tableId);
        if (!$tableId) {
            return $this->redirect('/tables', navigate: true);
        }

        $table = Table::find($tableId);

        if ($table) {
            $table->update([
                'status' => 'available'
            ]);
        }

        session()->forget('table_id');
        session()->forget('table_name');
        session()->forget('cart_' . $tableId);

        $this->redirect('/tables', navigate: true);
    }

    public function toggleTableStatus($id)
    {
        $table = Table::findOrFail($id);

        // toggle status
        if ($table->status === 'used') {
            $table->update(['status' => 'available']);
        } else {
            $table->update(['status' => 'used']);
        }
    }

    public function render()
    {
        return view('livewire.select-table', [
            'tables' => Table::all()
        ])->layout('layouts.app');
    }
}
