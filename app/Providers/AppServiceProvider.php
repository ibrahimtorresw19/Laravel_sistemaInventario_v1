<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configuración de Passport
        $this->configurePassport();

        // Configuración de cookies seguras
        $this->configureSecureCookies();

        // Configuración de base de datos
        Schema::defaultStringLength(191);

        // Forzar HTTPS en producción
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Configuración de paginación
        Paginator::useBootstrapFive();

        // Configuración de tiempo de vida de sesión
        $this->configureSession();
    }

    protected function configurePassport(): void
    {
        Passport::loadKeysFrom(storage_path('oauth'));
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        Passport::tokensCan([
            'user-profile' => 'Acceso al perfil de usuario',
            'place-orders' => 'Permite realizar pedidos',
            'manage-inventory' => 'Gestionar inventario completo',
        ]);

        Passport::setDefaultScope([
            'user-profile',
        ]);
    }

    protected function configureSecureCookies(): void
    {
        Cookie::setDefaultPathAndDomain(
            '/',
            config('session.domain'),
            config('session.secure'),
            true, // httpOnly
            config('session.same_site', 'lax')
        );
    }

    protected function configureSession(): void
    {
        config([
            'session.lottery' => [2, 100], // Probabilidad de limpieza de sesiones
            'session.cookie_secure' => true,
            'session.cookie_samesite' => 'lax',
        ]);
    }
}