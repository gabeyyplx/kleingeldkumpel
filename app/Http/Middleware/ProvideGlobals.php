<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Formatting\Formatter;


class ProvideGlobals
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
                $user = Auth::user();
                $accounts = Account::where('user_id', $user->id)->get();
                $currentAccount = Account::find($user->current_account) ?? $accounts->first();
                $formatter = new Formatter($user, $currentAccount);
                $view->with(compact('user', 'accounts', 'currentAccount', 'formatter'));
            }
        });
        return $next($request);
    }
}
