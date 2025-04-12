<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\FixedPosition;
use App\Models\Category;
use App\FixedPositionPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FixedPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $account = Account::find($user->current_account) ?? Account::where('user_id', $user->id)->first();
        $fixed_positions = FixedPosition
            ::where('account_id', $account->id)
            ->with('category')
            ->latest()
            ->paginate(25);

            if($request->query('page')) {
                return view('fixed-positions.list', compact('fixed_positions', 'account'));
            }

        return view('fixed-positions.index', compact('fixed_positions', 'account'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $account = Account::find($user->current_account) ?? Account::where('user_id', $user->id)->first();
        $categories = Category::all();
        $periods = FixedPositionPeriod::cases();
        return view('fixed-positions.create', compact('categories', 'account', 'periods'));
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
            'start_date' => 'required|date',
        ]);
        $position = FixedPosition::create($request->all());
        return redirect()->route('fixed-positions.index')->with('success', 'Position created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        
        $user = Auth::user();
        $account = Account::find($user->current_account) ?? Account::where('user_id', $user->id)->first();
        $position = FixedPosition::with('category')->find($id);
        $categories = Category::all();
        $periods = FixedPositionPeriod::cases();
        return view('fixed-positions.edit', compact('position', 'categories', 'account', 'periods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $parameters = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'value' => 'required|numeric|min:0.01',
            'type' => 'required|in:expense,income',
            'name' => 'required|max:255',
            'start_date' => 'required|date'
        ]);
        $parameters['active'] = $request->has('active') ? true : false;
        $position = FixedPosition::find($id);
        if($position === null) {
            return redirect()->route('fixed-positions.index')->with('error', 'Position not found.');
        }
        $position->update($parameters);
        return redirect()->route('fixed-positions.index')->with('success', 'Position updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $position = FixedPosition::find($id);
        if($position === null) {
            return redirect()->route('fixed-positions.index')->with('error', 'Position not found.');
        }
        $position->delete();
        return redirect()->route('fixed-positions.index')->with('success', 'Position deleted successfully.');
    }
}
