<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $account = Account::find($user->current_account);
        $expenses = DB::table('transactions')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.account_id', $account->id)
            ->where('transactions.value', '<', 0)
            ->where('transactions.date', '>=', now()->startOfMonth())
            ->groupBy('categories.name')
            ->select('categories.name as name', DB::raw('SUM(transactions.value) as total'))
            ->get();
        return view('dashboard.index')->with(compact('account', 'expenses'));
    }
}
