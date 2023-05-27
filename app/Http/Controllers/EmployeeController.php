<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\EmployeeImage;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
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
        // $employees = Employee::where([
        //     ['lastname', '!=', Null],
        //     [function ($query) use ($request) {
        //         if ($term = $request->term) {
        //             $query->orWhere('lastname', 'LIKE', '%' . $term . '%')
        //                 ->orWhere('firstname', 'like', '%' . $term . '%')
        //                 ->get();
        //         }
        //     }]
        // ])
        $employees = DB::table('employees')
        ->join('employeeimages', 'employees.id', '=', 'employeeimages.employee_id')
        ->select('employees.id','employees.firstname','employees.lastname','employees.email','employees.phone_number','employees.gender','employees.created_at','employeeimages.url')
        ->orderBy('employees.id', 'desc')->paginate(10);

        $employees_display = DB::table('employees')
        ->select('employees.*', 'employeeimages.*')
        ->leftJoin('employeeimages', 'employeeimages.employee_id', 'employees.id', '=')
        ->orderBy('employees.id', 'desc')->paginate(10);
        
        $count = DB::table('employees')->count();
        // dd($employees_display);
        return view('Employee.index')->with(compact('employees','count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Employee.create');
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
        // Employee::create($request->post()); 
        $request->validate(['email'=>'unique:employees',
    'phone_number'=>'unique:employees']);
        $employee = new Employee();
        $employee['firstname'] = $request->firstname;
        $employee['lastname'] = $request->lastname;
        $employee['gender'] = $request->gender;
        $employee['email'] = $request->email;
        $employee['phone_number'] = $request->phone_number;

        $employee->save();


        $data = new EmployeeImage();

        if ($request->file('images')) {
            $file = $request->file('images');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('public/Image'), $filename);
            $data['url'] = $filename;
        }
        $data['employee_id'] = $employee->id;
        $data->save();

        return redirect()->route('employees.index')->with('success', 'Employee created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
        $image = DB::table('employees')
            ->join('employeeimages', 'employees.id', '=', 'employeeimages.employee_id')
            ->select('employeeimages.url')
            ->where('employeeimages.employee_id', '=', $employee->id)->get();
        return view('Employee.edit')->with(compact('employee'))->with(compact('image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
        $request->validate(['email'=>'unique',
        'phone_number'=>'unique']);
        $employee->fill($request->post())->save();

        return redirect()->route('employees.index')->with('success', 'Employee Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
        $deleteImage = DB::table('employeeimages')->where('employee_id', '=', $employee->id)->delete();
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee Has Been removed successfully');
    }
}
