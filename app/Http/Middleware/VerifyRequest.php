<?php

namespace App\Http\Middleware;

use Closure;
use Dingo\Api\Facade\Route;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Exception\ResourceException;

class VerifyRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeName = Route::currentRouteName();
        if ($routeName) {
            $rules = config('validation.' . $routeName . '.validation');
            if (!empty($rules)) {
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    throw new ResourceException(__($routeName . '.failed'), $validator->errors());
                }
            }
        }
        return $next($request);
    }
}