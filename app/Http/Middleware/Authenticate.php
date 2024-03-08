<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  ...$guards
     * @return mixed
     */
    protected function redirectTo($request, ...$guards)
    {
        return $request->expectsJson() ? auth()->user() : abort(401, 'Unauthorized');
    }
}
