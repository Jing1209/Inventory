<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuildingController extends Controller
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
        // $buildings = Building::orderBy('id','desc')->paginate(5);
        $buildings = Building::where([
            ['building', '!=', Null],
            [function ($query) use ($request) {
                if ($term = $request->term) {
                    $query->orWhere('building', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])->orderBy('id', 'asc')->paginate(10);
        $countBuilding = DB::table('buildings')->count();
        return view('Building.index')->with(compact('buildings'))->with(compact('countBuilding'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Building.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'building' => 'required|unique:buildings|max:255',
        ]);
        Building::create($request->post());
        return redirect()->route('buildings.index')->with('success', 'Building has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function show(Building $building)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function edit(Building $building)
    {
        return view('Building.edit', compact('building'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Building $building)
    {
        $request->validate([
            'building' => 'required|unique:buildings|max:255',
        ]);

        $building->fill($request->post())->save();
        return redirect()->route('buildings.index')->with('success', 'Building Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function destroy(Building $building)
    {
        $building->delete();
        return redirect()->route('buildings.index')->with('success', 'Building Has Been removed successfully');
    }
}
