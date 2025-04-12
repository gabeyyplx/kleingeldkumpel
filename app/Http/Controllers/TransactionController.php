<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $account = Account::find($user->current_account) ?? Account::where('user_id', $user->id)->first();
        $transactions = Transaction
            ::where('account_id', $account->id)
            ->with('category')
            ->latest()
            ->paginate(25);

            if($request->query('page')) {
                return view('transactions.list', compact('transactions', 'account'));
            }

        return view('transactions.index', compact('transactions', 'account'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $account = Account::find($user->current_account) ?? Account::where('user_id', $user->id)->first();
        $categories = Category::all();
        return view('transactions.create', compact('categories', 'account'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'value' => 'required|numeric|min:0.01',
            'type' => 'required|in:expense,income',
            'name' => 'required|max:255',
            'date' => 'required|date',
        ]);
        $transaction = Transaction::create($request->all());
        $balanceValue = $transaction->value;
        if($transaction->type === 'expense') {
            $balanceValue *= -1;
        }
        $account = Account::find($transaction->account_id);
        $account->balance += $balanceValue;
        $account->save();
        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $account = Account::find($user->current_account) ?? Account::where('user_id', $user->id)->first();
        $transaction = Transaction::with('category')->find($id);
        $categories = Category::all();
        return view('transactions.edit', compact('transaction', 'categories', 'account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'value' => 'required|numeric|min:0.01',
            'type' => 'required|in:expense,income',
            'name' => 'required|max:255',
            'date' => 'required|date',
        ]);
        $transaction = Transaction::find($id);
        if($transaction === null) {
            return redirect()->route('transactions.index')->with('error', 'Transaction not found.');
        }
        $oldValue = $transaction->value;
        if($transaction->type === 'expense') {
            $oldValue *= -1;
        }
        $balanceValue = $request->value;
        if($request->type === 'expense') {
            $balanceValue *= -1;
        }
        $difference = $balanceValue - $oldValue;
        $account = Account::find($transaction->account_id);
        $account->balance += $difference;
        $account->save();
        $transaction->update($request->all());
        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);
        if($transaction === null) {
            return redirect()->route('transactions.index')->with('error', 'Transaction not found.');
        }
        $account = Account::find($transaction->account_id);
        $balanceValue = $transaction->value;
        if($transaction->type === 'expense') {
            $balanceValue *= -1;
        }
        $account->balance -= $balanceValue;
        $account->save();
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
