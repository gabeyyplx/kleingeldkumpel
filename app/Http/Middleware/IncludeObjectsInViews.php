<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Formatters\CurrencyFormatter;
use App\Formatters\DateFormatter;


class IncludeObjectsInViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('user', Auth::user());
                $view->with('accounts', Account::where('user_id', Auth::id())->get());
            }
            $view->with('CurrencyFormatter', new CurrencyFormatter());
            $view->with('DateFormatter', new DateFormatter());
        });
        return $next($request);
    }
}
