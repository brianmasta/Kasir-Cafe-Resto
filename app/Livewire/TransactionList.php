<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;

class TransactionList extends Component
{
    public $transactions = [];

    public $openId = null;

    public function mount()
    {
        $this->loadData();
    }

    public function toggleDetail($id)
    {
        if ($this->openId === $id) {
            $this->openId = null;
        } else {
            $this->openId = $id;
        }
    }

    public function loadData()
    {
        $this->transactions = Transaction::with(['details', 'table', 'user'])
            ->latest()
            ->get();
    }
    
    public function getTotalTodayProperty()
    {
        return Transaction::whereDate('created_at', today())->sum('total');
    }

    public function render()
    {
        return view('livewire.transaction-list')
            ->layout('layouts.app');
    }
}
