<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
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
        $rooms = DB::table('rooms')
            ->join('buildings', 'rooms.building_id', '=', 'buildings.id')
            ->select('rooms.id', 'rooms.name', 'rooms.building_id', 'buildings.building')
            ->where(function ($query) use ($request) {
                if ($term = $request->term) {
                    $query->where('rooms.name', 'LIKE', '%' . $term . '%');
                    // ->orWhere('buildings.buidling','like','%'.$term.'%');
                }
            })
            ->orderBy('id', 'asc')->paginate(10);
        $countRoom = DB::table('rooms')->count();
        $buildings = Building::orderBy('id', 'desc')->get();
        return view('Room.index')->with(compact('rooms'))->with(compact('buildings'))->with(compact('countRoom'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $buildings = Building::orderBy('id', 'desc')->paginate(0);
        return view('Room.create')->with(compact('buildings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name'=>'unique:rooms']);
        Room::create($request->post());
        return redirect()->route('rooms.index')->with('success', 'Room has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        // return new RoomResource($room);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        $buildings = Building::orderBy('id', 'desc')->paginate(0);
        return view('Room.edit')->with(compact('room'))->with(compact('buildings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $request->validate(['name'=>'unique:rooms']);
        $room->fill($request->post())->save();
        return redirect()->route('rooms.index')->with('success', 'Room Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room Has Been removed successfully');
    }
}
