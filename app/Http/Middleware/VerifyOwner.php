<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $class)
    {

        $className = 'App\\' . ucfirst($class);
        $model = $className::findOrFail(reset($request->route()->parameters));

            if($model->getOwner()->id == Auth::id()) {
                return $next($request);
            }
        return redirect(route("home"))->withErrors(["You don't have permission to perform this action "]);
    }
}
