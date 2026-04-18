<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>POS Restoran</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            overflow: hidden;
            background: #eef1f5;
        }

        /* SIDEBAR */
        .sidebar {
            height: 100vh;
            width: 240px;
            position: fixed;
            background: linear-gradient(180deg, #1e3c72, #2a5298);
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            border-radius: 10px;
            padding: 10px 12px;
            transition: 0.3s;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: #fff;
            font-weight: 600;
        }

        /* CONTENT */
        .content {
            margin-left: 240px;
            height: 100vh;
            overflow-y: auto;
        }

        /* TOPBAR */
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #ddd;
        }

        /* CARD */
        .card {
            border-radius: 15px;
            border: none;
        }

        /* BUTTON */
        .btn-primary {
            transition: 0.3s;
            border-radius: 10px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        /* ANIMASI APP */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .app-fade {
            animation: fadeIn 0.4s ease-in-out;
        }

        /* 🔥 SPLASH SCREEN (FIRST LOAD) */
        #splash-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg,#1e3c72,#2a5298);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }

        #splash-screen h2 {
            animation: fadeIn 0.6s ease;
        }

        /* loading dots */
        .loading-dots::after {
            content: '';
            animation: dots 1.5s infinite;
        }

        @keyframes dots {
            0% { content: ''; }
            33% { content: '.'; }
            66% { content: '..'; }
            100% { content: '...'; }
        }

        /* 🔥 LIVEWIRE LOADING OVERLAY */
        .lw-loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9998;
        }

        .lw-box {
            animation: fadeIn 0.3s ease;
        }
    </style>
</head>

<body>

<!-- 🔥 SPLASH (HANYA FIRST LOAD) -->
{{-- <div id="splash-screen">
    <div class="text-center text-white">
        <h2 class="fw-bold">🍽️ POS Restoran</h2>
        <small class="loading-dots">Loading</small>
    </div>
</div> --}}

<!-- 🔥 LIVEWIRE GLOBAL LOADING -->
<div wire:loading.delay
     class="lw-loading">

    <div class="text-center text-white lw-box">
        <div class="spinner-border mb-2"></div>
        <div>Memproses...</div>
    </div>

</div>

<!-- 🔵 TOPBAR -->
<nav class="navbar topbar px-4 d-flex justify-content-between">
    <div class="fw-bold">🍽️ POS Restoran</div>

    <div class="d-flex align-items-center gap-3">

        <!-- JAM -->
        <div class="text-muted small">
            🕒 {{ now()->format('H:i') }}
        </div>

        <!-- USER -->
        <div class="fw-semibold">
            {{-- 👤 {{ auth()->user()->name }} --}}
        </div>

        <!-- LOGOUT -->
        <livewire:logout-button />

    </div>
</nav>

<div class="d-flex">

    <!-- 🟢 SIDEBAR -->
    <div class="sidebar text-white p-3">

        <h5 class="mb-4">MENU</h5>

        <ul class="nav flex-column">

            <li class="nav-item mb-2">
                <a href="/tables" class="nav-link active">
                    <i class="bi bi-house"></i> Dashboard
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="/kasir" class="nav-link">
                    <i class="bi bi-cart"></i> Kasir
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="/menu" class="nav-link">
                    <i class="bi bi-grid"></i> Menu
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="/transaksi" class="nav-link">
                    <i class="bi bi-receipt"></i> Transaksi
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="/kitchen-food" class="nav-link">
                    <i class="bi bi-fire"></i> Food Display
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="/kitchen-drink" class="nav-link">
                    <i class="bi bi-cup-straw"></i> Drink Display
                </a>
            </li>

        </ul>

    </div>

    <!-- 🟡 CONTENT -->
    <div class="content p-4 w-100 app-fade">
        {{ $slot }}
    </div>

</div>

@livewireScripts

<!-- 🔥 SCRIPT SPLASH -->
<script>
window.addEventListener('load', function () {
    const splash = document.getElementById('splash-screen');

    setTimeout(() => {
        splash.style.opacity = '0';

        setTimeout(() => {
            splash.remove();
        }, 500);

    }, 800);
});
</script>

</body>
</html>