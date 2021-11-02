<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('/');
        }
    }
    public function handle($request, Closure $next, ...$guards)
    {
        // Like: users.index
        $route = app()->router->getCurrentRoute();
        $route_name = $route->getName();
        if ($route_name != '') {
            $route_prefix = $route->getPrefix();
            if ($route_prefix == "")
                $route_prefix = "web";
            // @var \App\User $user
            $user = auth(...$guards)->user();
            $guest_perrmission = config('permission.guest_permission');
            // Hasn't permission
            if (!in_array($route_name, $guest_perrmission) && !empty($user) && !$user->isSuperAdmin() && !$user->hasPermissionTo($route_name, $route_prefix)) {
                return abort(403);
            }
        }
        return parent::handle($request, $next, ...$guards);
    }
}
