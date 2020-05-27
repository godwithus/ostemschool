<?php

namespace App\Http\Middleware;

use Closure;
use App\BlogAdmin;
use App\CreateSite;

class CheckUserAccess
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
        $getUrl = explode('.', $_SERVER['HTTP_HOST'])[0];
        $getByDomain = CreateSite::where('domain', $getUrl)
                        ->first();

        $getAdmin = BlogAdmin::where('site_id', $getByDomain->id)
                    ->where('user_id', $request->user()->id)
                    ->first();

        if (($getByDomain != null && $getByDomain->user_id == $request->user()->id) || $getAdmin != null) {
            return $next($request);
        }

        abort(403, 'You do not have access to this module');
    }
}
