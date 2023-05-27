<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class ReturnController extends Controller
{
    public function returned(Request $request, $id)
    {
        $returned = Transaction::find($id);
        $returned['status'] = $request->status;
        $returned['returned_date'] = Carbon::now();
        $returned->save();
        return redirect()->route('transactions.index');
    }
    public function search(Request $request)
    {
        $query = $request->input('status');
        $transaction = Transaction::where('status','=',$query)->get();
        dd($query, $transaction);
        return $transaction->orderBy('id', 'DESC')->paginate(10);
    }
}
