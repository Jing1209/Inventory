<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('dashboard');
        $users = Category::select('quantity', 'category')
            // ->whereYear('created_at', date('d'))
            // ->groupBy('category')
            ->pluck('quantity', 'category');
        // ->get();

        $labels = $users->keys();
        $data = $users->values();
        // dd($users);
        $countBad = DB::table('items')
            ->join('statuses', 'items.status', '=', 'statuses.id')
            ->where('statuses.status', 'like', '%Bad%')->count();
        $countGood = DB::table('items')
            ->join('statuses', 'items.status', '=', 'statuses.id')
            ->where('statuses.status', 'like', '%Good%')->count();
        $countMedium = DB::table('items')
            ->join('statuses', 'items.status', '=', 'statuses.id')
            ->where('statuses.status', 'like', '%Medium%')->count();
        $countBroken = DB::table('items')
            ->join('statuses', 'items.status', '=', 'statuses.id')
            ->where('statuses.status', 'like', '%Broken%')->count();
        // dd($countBad);


        $transactions = DB::table('transactions')
            ->select('transactions.*', 'items.title as ItemName', 'items.id as ItemId', 'buildings.building as BuildingName', 'buildings.id as BuildingId', 'rooms.name as RoomName', 'rooms.id as RoomId', 'employees.lastname as EmployeeLastname', 'employees.firstname as EmployeeFirstname', 'employees.id as EmployeeId', 'statuses.status as ConditionName', 'statuses.id as ConditionId')
            ->leftJoin('items', 'items.id', 'transactions.item_id')
            ->leftJoin('rooms', 'rooms.id', 'transactions.room_id')
            ->leftJoin('buildings', 'buildings.id', 'transactions.building_id')
            ->leftJoin('employees', 'employees.id', 'transactions.employee_id')
            ->leftJoin('statuses', 'statuses.id', 'transactions.condition')
            ->where('transactions.status', 'Borrowed')
            ->orderBy('transactions.id', 'DESC')
            ->take(3)->get();
        // dd($transactions);

        $items = DB::table('items')
            ->select('items.*', 'categories.category as categoryName', 'statuses.status as statusName', 'sponsors.name as sponsorName')
            ->leftJoin('categories', 'categories.id', 'items.category_id')
            ->leftJoin('statuses', 'statuses.id', 'items.status')
            ->leftJoin('sponsors', 'sponsors.id', 'items.sponsored')
            ->orderBy('items.id', 'DESC')
            ->take(3)->get();
        // dd($items);



        return view('dashboard')->with(compact('labels', 'data', 'countBad', 'countGood', 'countMedium', 'countBroken', 'transactions', 'items'));
    }
}
