<?php

namespace App\Livewire;

use App\Models\Table;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SelectTable extends Component
{


    public function mount()
    {
        if (!auth()->check()) {
            $this->redirect('/', navigate: true);
            return;
        }
    }

    public function selectTable($id)
    {
        $table = Table::find($id);

        if (!$table) {
            return;
        }

        session()->put('table_id', $table->id);
        session()->put('table_name', $table->name);

        $this->redirect('/dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.select-table', [
            'tables' => Table::all()
        ])->layout('layouts.app');
    }
}
