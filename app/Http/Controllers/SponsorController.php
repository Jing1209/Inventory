<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SponsorController extends Controller
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
        $sponsors = Sponsor::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if ($term = $request->term) {
                    $query->orWhere('name', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])->orderBy('id', 'asc')->paginate(10);
        $countSponsor = DB::table('sponsors')->count();
        return view('Sponsor.index')->with(compact('sponsors'))->with(compact('countSponsor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Sponsor.create');
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
        $request->validate(['name'=>'unique:sponsors']);
        Sponsor::create($request->post());
        return redirect()->route('sponsor.index')->with('success', 'Sponsor has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function show(Sponsor $sponsor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function edit(Sponsor $sponsor)
    {
        //
        return view('Sponsor.edit', compact('sponsor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        //
        $request->validate(['name'=>'unique']);
        $sponsor->fill($request->post())->save();
        return redirect()->route('sponsor.index')->with('success', 'Sponsor Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sponsor $sponsor)
    {
        //
        $sponsor->delete();
        return redirect()->route('sponsor.index')->with('success', 'Sponsor Has Been deleted successfully');
    }
}
