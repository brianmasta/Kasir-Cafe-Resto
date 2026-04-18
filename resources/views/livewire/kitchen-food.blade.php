<div>
    <div class="container-fluid p-4" style="background:#000814; min-height:100vh;" wire:poll.2s>

        <h3 class="text-white mb-4 text-center">📺 BAR TV MODE</h3>

        @foreach($orders as $tableName => $items)

            {{-- 🪑 HEADER MEJA --}}
            <div class="card bg-dark text-white mb-3 p-2 text-center">
                <h5>🪑 {{ $tableName }}</h5>
            </div>

            <div class="row">

                @foreach($items as $item)

                    @php
                        $minutes = $item->cooking_started_at
                            ? \Carbon\Carbon::parse($item->cooking_started_at)->diffInMinutes(now())
                            : 0;
                    @endphp

                    <div class="col-md-3 mb-3">

                        <div class="card p-3 text-white shadow"

                            {{-- 🎨 COLOR LOGIC --}}
                            style="
                                background:
                                @if($item->status == 'pending')
                                    #dc3545;
                                @elseif($item->status == 'cooking' && $minutes < 3)
                                    #198754;
                                @elseif($item->status == 'cooking' && $minutes < 7)
                                    #ffc107;
                                @elseif($item->status == 'cooking' && $minutes >= 7)
                                    #ff0000;
                                @else
                                    #343a40;
                                @endif
                            "

                        >

                            {{-- 🥤 ITEM --}}
                            <h5>🥤 {{ $item->name }} (x{{ $item->qty }})</h5>

                            <small>Invoice: {{ $item->transaction->invoice }}</small>

                            <hr>

                            {{-- ⏱ TIMER --}}
                            @if($item->cooking_started_at)
                            @php
                                $seconds = $item->cooking_started_at
                                    ? \Carbon\Carbon::parse($item->cooking_started_at)->diffInSeconds(now())
                                    : 0;

                                $minutes = floor($seconds / 60);
                                $remainingSeconds = $seconds % 60;
                            @endphp

                            <h4 class="fw-bold">
                                ⏱ {{ str_pad($minutes, 2, '0', STR_PAD_LEFT) }}:
                                {{ str_pad($remainingSeconds, 2, '0', STR_PAD_LEFT) }}
                            </h4>
                            @else
                                <h6>⏱ Belum mulai</h6>
                            @endif

                            {{-- STATUS --}}
                            <div class="mt-2">
                                @if($item->status === 'pending')
                                    <span class="badge bg-light text-dark">Pending</span>
                                @elseif($item->status === 'cooking')
                                    <span class="badge bg-dark">Cooking</span>
                                @else
                                    <span class="badge bg-success">Done</span>
                                @endif
                            </div>

                            <hr>

                            {{-- BUTTON --}}
                            <button wire:click="updateStatus({{ $item->id }}, 'cooking')"
                                    class="btn btn-light w-100 mb-2"
                                    @if($item->status === 'cooking') disabled @endif>
                                🍹 Proses
                            </button>

                            <button wire:click="updateStatus({{ $item->id }}, 'done')"
                                    class="btn btn-dark w-100">
                                ✔ Selesai
                            </button>

                        </div>

                    </div>

                @endforeach

            </div>

        @endforeach

    </div>
</div>