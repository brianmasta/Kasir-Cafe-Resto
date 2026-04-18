<?php

namespace App\Livewire;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Livewire\Component;

class KitchenDrink extends Component
{
    protected $listeners = ['refreshKds' => '$refresh'];

    /* =========================
        UPDATE PER ITEM
    ========================= */
    public function updateStatus($detailId, $status)
    {
        $detail = TransactionDetail::findOrFail($detailId);

        $data = [
            'status' => $status,
        ];

        if ($status === 'cooking') {
            if (!$detail->cooking_started_at) {
                $data['cooking_started_at'] = now();
            }
        }

        if ($status === 'done') {
            $data['cooking_finished_at'] = now();
        }

        $detail->update($data);

        $this->dispatch('refreshKds');
    }

    public function cookingDuration($time)
    {
        if (!$time) return 0;

        return Carbon::parse($time)->diffInMinutes(now());
    }

    /* =========================
        RENDER DATA KDS
    ========================= */
    public function render()
    {
        $details = TransactionDetail::with(['transaction.table'])
            ->where('category', 'drink')
            ->whereIn('status', ['pending', 'cooking'])
            ->orderBy('created_at')
            ->get();

        // 🔥 grouping per meja
        $orders = $details->groupBy(function ($item) {
            return $item->transaction->table->name ?? 'Tanpa Meja';
        });

        return view('livewire.kitchen-drink', compact('orders'))
            ->layout('layouts.app');
    }
}
