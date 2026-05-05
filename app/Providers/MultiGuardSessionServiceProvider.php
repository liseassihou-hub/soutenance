<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Session\SessionManager;

class MultiGuardSessionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Set session cookie name based on the current guard
        $this->app->booted(function () {
            $guard = $this->getCurrentGuard();
            
            if ($guard && isset(config('session.guard_cookies')[$guard])) {
                $cookieName = config('session.guard_cookies')[$guard];
                
                // Update session configuration
                config(['session.cookie' => $cookieName]);
                
                // Update session manager if already resolved
                if ($this->app->bound('session')) {
                    $sessionManager = $this->app->make('session');
                    if ($sessionManager instanceof SessionManager) {
                        $sessionManager->setCookieName($cookieName);
                    }
                }
            }
        });
    }

    /**
     * Get the current authentication guard
     */
    private function getCurrentGuard(): ?string
    {
        // Check if user is authenticated with agent guard
        if (auth('agent')->check()) {
            return 'agent';
        }
        
        // Check if user is authenticated with admin guard
        if (auth('admin')->check()) {
            return 'admin';
        }
        
        // Check if user is authenticated with web guard
        if (auth()->check()) {
            return 'web';
        }
        
        return null;
    }
}
