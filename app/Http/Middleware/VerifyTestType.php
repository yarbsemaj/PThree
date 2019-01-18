<?php

namespace App\Http\Middleware;

use App\Test;
use Closure;

class VerifyTestType
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
        $model = Test::findOrFail(reset($request->route()->parameters));

        if ($model->testable_type == $className) {
            return $next($request);
        }
        return redirect(route("home"))->withErrors(["You the test id and type do not match"]);
    }
}
