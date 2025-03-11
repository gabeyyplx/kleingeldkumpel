<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $account = Account::first();
        $transactions = Transaction::with('category')->latest()->get();
        return view('transactions.index', compact('transactions', 'account'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $account = Account::first();
        return view('transactions.create', compact('categories', 'account'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'value' => 'required|numeric',
            'name' => 'required|max:255',
            'date' => 'required|date',
        ]);
        Transaction::create($request->all());
        $account = Account::find($request->account_id);
        $account->balance += $request->value;
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
        $account = Account::first();
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
            'value' => 'required|numeric',
            'name' => 'required|max:255',
            'date' => 'required|date',
        ]);
        $transaction = Transaction::find($id);
        if($transaction === null) {
            return redirect()->route('transactions.index')->with('error', 'Transaction not found.');
        }
        $difference = $request->value - $transaction->value;
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
        $account->balance -= $transaction->value;
        $account->save();
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
