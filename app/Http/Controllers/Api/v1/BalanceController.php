<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminatech\Balance\Facades\Balance;

class BalanceController extends Controller
{
    //

    public function index(Request $request) {
        return Balance::calculateBalance(Auth::id());
    }
}
