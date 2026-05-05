<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Foundation\Http\Middleware\TrustProxies;
use Illuminate\Foundation\Http\Middleware\TranscodeRequestContent;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\TrustHosts;
use App\Http\Middleware\AppTrustProxies;
use App\Http\Middleware\TrimStrings as AppTrimStrings;
use App\Http\Middleware\PreventRequestsDuringMaintenance as AppPreventRequestsDuringMaintenance;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RedirectAuthenticated;
use Illuminate\Auth\Middleware\Authenticate as MiddlewareAuthenticate;
use Illuminate\Session\Middleware\StartSession as MiddlewareStartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession as MiddlewareShareErrorsFromSession;
use Illuminate\Routing\Middleware\SubstituteBindings as MiddlewareSubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests as MiddlewareThrottleRequests;
use Illuminate\Auth\Middleware\Authorize as MiddlewareAuthorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified as MiddlewareEnsureEmailIsVerified;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AgentMiddleware;
use App\Http\Middleware\PEBCO\AdminRole;
use App\Http\Middleware\PEBCO\AgentRole;
use App\Http\Middleware\CheckSessionAuth;
use App\Http\Middleware\CheckAdminSession;
use App\Http\Middleware\CheckAgentSession;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\AppTrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\AppPreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\AppTrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\TranscodeRequestContent::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'auth.admin' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.agent' => \Illuminate\Auth\Middleware\Authenticate::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'redirect.authenticated' => \App\Http\Middleware\RedirectAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'agent' => \App\Http\Middleware\AgentMiddleware::class,
        'role' => \App\Http\Middleware\CheckRole::class,
        'admin.guard' => \App\Http\Middleware\AdminGuard::class,
        'admin.auth' => \App\Http\Middleware\AdminAuth::class,
        'admin_check' => \App\Http\Middleware\AdminAuth::class,
        'pebco.admin' => \App\Http\Middleware\PEBCO\AdminRole::class,
        'pebco.agent' => \App\Http\Middleware\PEBCO\AgentRole::class,
        'session.auth' => \App\Http\Middleware\CheckSessionAuth::class,
        'session.admin' => \App\Http\Middleware\CheckAdminSession::class,
        'session.agent' => \App\Http\Middleware\CheckAgentSession::class,
        'client.status.check' => \App\Http\Middleware\ClientStatusCheck::class,
        'agent.auth' => \App\Http\Middleware\AgentAuthMiddleware::class,
    ];
}
