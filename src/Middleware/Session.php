<?php

namespace Encore\Admin\Middleware;

use Illuminate\Http\Request;

class Session
{
    public function handle(Request $request, \Closure $next)
    {
        // get baseUrl
        $baseUrl = trim(request()->getBaseUrl(), '/');
        $path = (!empty($baseUrl) ? '/'.$baseUrl : '') .'/'.trim(config('admin.route.prefix'), '/');

        config(['session.path' => $path]);

        if ($domain = config('admin.route.domain')) {
            config(['session.domain' => $domain]);
        }

        return $next($request);
    }
}
