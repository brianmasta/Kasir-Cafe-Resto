<?php

namespace App\Livewire;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Livewire\Component;

class KitchenFood extends Component
{
    protected $listeners = [
        'refreshKds' => '$refresh',
    ];
    

    public function updateStatus($detailId, $status)
    {
        $detail = TransactionDetail::findOrFail($detailId);

        if ($status === 'cooking' && !$detail->cooking_started_at) {
            $detail->update([
                'status' => 'cooking',
                'cooking_started_at' => now(),
            ]);
        }

        if ($status === 'done') {
            $detail->update([
                'status' => 'done',
                'cooking_finished_at' => now(),
            ]);
        }

        $this->dispatch('refreshKds');
    }

    public function startCooking($detailId)
    {
        $detail = TransactionDetail::findOrFail($detailId);

        $detail->update([
            'status' => 'cooking',
            'cooking_started_at' => now(),
        ]);
    }

    public function finishCooking($detailId)
    {
        $detail = TransactionDetail::findOrFail($detailId);

        $detail->update([
            'status' => 'done',
            'cooking_finished_at' => now(),
        ]);
    }

    public function cookingDuration($time)
    {
        if (!$time) return 0;

        return Carbon::parse($time)->diffInMinutes(now());
    }

    public function render()
    {
        $details = TransactionDetail::with('transaction.table')
        ->where('category', 'food')
        ->whereIn('status', ['pending', 'cooking'])
        ->orderBy('created_at')
        ->get();

        // 🔥 grouping per meja
        $orders = $details->groupBy(function ($item) {
            return $item->transaction->table->name ?? 'Tanpa Meja';
        });

        return view('livewire.kitchen-food', compact('orders'))->layout('layouts.app');
    }
}
