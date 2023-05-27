<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;    
use Illuminate\Support\Facades\Hash;
class SettingController extends Controller
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

    public function index()
    {  
        $user = auth()->user();
        $users = User::all()->except($user->id);
        return view('setting')->with(\compact('user'))->with(\compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \view('change-password');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                # Validation
                $request->validate([
                    'old_password' => 'required',
                    'new_password' => 'required|confirmed',
                ]);
        
        
                #Match The Old Password
                if(!Hash::check($request->old_password, auth()->user()->password)){
                    return back()->with("error", "Old Password Doesn't match!");
                }
        
        
                #Update the new Password
                User::whereId(auth()->user()->id)->update([
                    'password' => Hash::make($request->new_password)
                ]);
        
                return back()->with("status", "Password changed successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
