<?php

namespace App\Providers;

// Impor yang dibutuhkan
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Peta dari kebijakan (policy) aplikasi untuk model.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        // Contoh:
        // \App\Models\Post::class => \App\Policies\PostPolicy::class,
    ];

    /**
     * Daftarkan layanan otorisasi/otentikasi aplikasi.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // --------------------------------------------------------
        // Bagian di mana Anda mendaftarkan "Gate" (Gerbang Otorisasi)
        // --------------------------------------------------------

        // Contoh mendaftarkan Gate
        /*
        Gate::define('edit-settings', function ($user) {
            // Logika untuk memeriksa apakah pengguna (user) memiliki izin
            return $user->isAdmin();
        });
        */
    }
}