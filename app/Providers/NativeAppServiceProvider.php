<?php

namespace App\Providers;

use Native\Laravel\Facades\Window;
use Native\Laravel\Contracts\ProvidesPhpIni;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        Window::open(); // tetap pakai di kasus kamu

        Window::title('POS Restoran');

        // 🔥 ini yang bikin fullscreen langsung
        Window::fullscreen();

        // opsional (biar benar-benar seperti mesin kasir)
        Window::resizable(false);

        // fokus window
        Window::focus();

        if (app()->isLocal()) {
            Window::openDevTools();
        }
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [
        ];
    }
}
