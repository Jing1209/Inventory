<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Room;
use App\Models\Status;
use App\Models\Item;
use App\Models\Building;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\PDF;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        //
        $rooms = DB::table('rooms')
            ->join('buildings', 'rooms.building_id', '=', 'buildings.id')
            ->select('buildings.building', 'rooms.name', 'rooms.id')
            ->get();
        // $rooms = Room::orderBy('id','desc')->get();
        $buildings = Building::orderBy('id', 'desc')->get();

        $items = Item::orderBy('id', 'desc')->get();
        $employees = Employee::orderBy('id', 'desc')->get();

        $transactions = DB::table('transactions')
            ->select('transactions.*', 'items.title as ItemName','items.id as ItemId', 'buildings.building as BuildingName','buildings.id as BuildingId', 'rooms.name as RoomName','rooms.id as RoomId', 'employees.lastname as EmployeeLastname', 'employees.firstname as EmployeeFirstname','employees.id as EmployeeId', 'statuses.status as ConditionName','statuses.id as ConditionId')
            ->leftJoin('items', 'items.id', 'transactions.item_id')
            ->leftJoin('rooms', 'rooms.id', 'transactions.room_id')
            ->leftJoin('buildings', 'buildings.id', 'transactions.building_id')
            ->leftJoin('employees', 'employees.id', 'transactions.employee_id')
            ->leftJoin('statuses', 'statuses.id', 'transactions.condition')
            ->paginate(10);

        // $transactions = DB::table('transactions')
        //             ->join('items','transactions.item_id','=','items.id')
        //             ->join('employees','transactions.employee_id','=','employees.id')
        //             ->join('rooms','transactions.room_id','=','rooms.id')
        //             ->join('statuses','transactions.status','=','statuses.id')
        //             ->select('transactions.id','transactions.created_at','items.title','items.status','employees.firstname','employees.lastname','statuses.status'
        //                 ,DB::raw("(select * from buildings where buildings.id = rooms.building_id GROUP BY buildings.id)")
        //             )
        //             ->paginate(10);
        //             dd($transactions);
        $statuses = Status::orderBy('id', 'desc')->paginate(0);
        $countBorrow = DB::table('transactions')
            ->where('transactions.status', 'Borrowed')->count();
        $countReturn = DB::table('transactions')
            ->where('transactions.status', 'Returned')->count();
        // dd($transactions);
        return view('Transaction.index')->with(compact('transactions'))->with(compact('rooms'))->with(compact('items'))->with(compact('employees'))->with(compact('statuses'))->with(compact('countBorrow'))->with(compact('countReturn'))->with(compact('buildings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $rooms = Room::orderBy('id', 'desc')->get();
        $buildings = Building::orderBy('id', 'desc')->get();
        $items = Item::orderBy('id', 'desc')->get();
        $employees = Employee::orderBy('id', 'desc')->get();
        $status = Status::orderBy('id', 'desc')->get();
        return view('Transaction.create')->with(compact('rooms'))->with(compact('items'))->with(compact('employees'))->with(compact('status'))->with(compact('buildings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $request->validate([
            'item_id' => 'required',
            'room_id' => 'required',
            'employee_id' => 'required',
            'status' => 'required',
            'building_id' => 'required'

        ]);
        // Transaction::create($request->post());
        $transaction = new Transaction();
        $transaction['item_id'] = $request->item_id;
        $transaction['room_id'] = $request->room_id;
        $transaction['employee_id'] = $request->employee_id;
        $transaction['condition'] = $request->condition;
        $transaction['building_id'] = $request->building_id;
        $transaction['returned_date'] = NULL;
        $transaction['status'] = 'Borrowed';

        $transaction->save();

        return redirect()->route('transactions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
        $rooms = DB::table('rooms')
            ->join('buildings', 'rooms.building_id', '=', 'buildings.id')
            ->select('buildings.building', 'rooms.name', 'rooms.id')
            ->get();
        $items = Item::orderBy('id', 'desc')->get();
        // dd($items);
        return view('Transaction.edit')->with(compact('transaction'))->with(compact('rooms'))->with(compact('items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // $transaction->fill($request->post())->save();
        //
        // dd($request);
        $transaction = Transaction::find($id);
        // $request->validate([
        //     'item_id' => 'required',
        //     'room_id' => 'required',
        //     'employee_id' => 'required',
        //     'status' => 'required',
        //     'building_id' => 'required'

        // ]);
        // Transaction::create($request->post());
        $transaction['item_id'] = $request->item_id;
        $transaction['room_id'] = $request->room_id;
        $transaction['employee_id'] = $request->employee_id;
        $transaction['condition'] = $request->condition;
        $transaction['status'] = 'Borrowed';
        $transaction['returned_date'] = NULL;
        $transaction->save();
        return redirect()->route('transactions.index')->with('success', 'Transaction Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction Has Been removed successfully');
    }

    public function createPDF()
    {
        $date = Transaction::first();
        $newdate = $date->created_at->format('Y-m-d');
        // dd($newdate);
        
        $transactions = DB::table('transactions')
            ->join('items', 'transactions.item_id', '=', 'items.id')
            ->join('employees', 'transactions.employee_id', '=', 'employees.id')
            ->join('rooms', 'transactions.room_id', '=', 'rooms.id')
            ->join('statuses', 'transactions.status', '=', 'statuses.id')
            ->join('buildings', 'transactions.building_id', '=', 'buildings.id')
            ->select('transactions.id', 'transactions.created_at', 'items.title', 'items.item_id', 'items.price', 'items.status', 'employees.firstname', 'employees.lastname', 'rooms.name', 'buildings.building')
            ->paginate(10);

        return view('Transaction.pdf')->with(compact('transactions'));
        // $pdf = PDF::loadView('Transaction.pdf');

        // return $pdf->download('itsolutionstuff.pdf');
    }
}
