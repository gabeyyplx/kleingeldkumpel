<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   public function updateCurrentAccount(Request $request) {
      $accountId = $request->input('current_account');
      $user = Auth::user();
      $user->current_account = $accountId;
      $user->save();
      return redirect()->back();
   }
}
