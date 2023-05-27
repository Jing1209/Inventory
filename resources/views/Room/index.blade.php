@extends('layouts.app')
@section('title', 'Room')
@section('content')
<div class="container text-center">
    <h2 class="modal-title p-2" id="buildingModalLabel">Room Inventory</h2>
</div>
<div style="position: sticky;padding: 10px 0px 0 0px; top: 60px; overflow: hidden;background: #e4e9f7;" class="d-flex justify-content-between mb-3">
    <div class="w-25 d-flex justify-content-start text-white bg-primary rounded-2 me-2">
        <div class="mx-3 my-3">
            Total Room
            <div>
                {{$countRoom}}
            </div>
        </div>
    </div>
    <div class=" w-75 d-flex align-items-center text-white bg-white rounded-2 me-2">
        <div class="d-flex w-100 justify-content-between px-3">
            {{-- search bar --}}
            <form class="w-50" action="{{ route('rooms.index') }}" method="GET" role="search">
                <div class="d-flex justify-content-start">
                    <div class="input-group">
                        <input type="text" class="form-control mr-2 w-100 ps-3" name="term" placeholder="Search Room" id="term">
                    </div>
                    <span class="input-group-btn ms-2">
                        <button class="btn btn-primary d-flex align-items-center h-100" type="submit" title="Search Room">
                            <i style=" font-size: 18px;" class='bx bx-search'></i>
                        </button>
                    </span>
                </div>
            </form>
            <div>
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addnewRoom"><i style="font-size: 18px;" class="bx bx-plus me-2"></i>Add New</button>
            </div>
        </div>
    </div>
</div>

{{-- Table of Room  --}}
<div class="mt-1 rounded bg-white">
    <table class="table table-striped table-hover" id="myTable">
        <thead class="border-bottom">
            <tr class="table-primary">
                <th scope="col" style="padding-left: 20px;">S.No</th>
                <th scope="col">Room title</th>
                <th scope="col">Building Title</th>
                <th scope="col" style="width: 200px; text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rooms as $room)
                
                <tr>
                    <td style="padding-left: 20px;">{{ $room->id }}</td>
                    <td>{{ $room->name }}</td>
                    <td>{{ $room->building }}</td>  
                    <td style="text-align: center;">
                        <a class="btn btn-warning text-white" href="#viewRoom{{ $room->id }}" data-bs-toggle="modal">View</a>
                        <a href="#editRoom{{$room->id}}" data-bs-toggle="modal" class="btn btn-primary">
                            Edit
                         </a> 
                         <a href="#deleteClarify{{$room->id}}" data-bs-toggle="modal" class="btn btn-danger">
                            Delete
                        </a> 
                         {{-- Comfirm Delete Room  --}}
                        <div class="modal fade" id="deleteClarify{{$room->id}}" tabindex="-1" aria-labelledby="deleteBuildingModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="deleteBuildingModalLabel">Confirm Message</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('rooms.destroy',$room->id) }}" method="Post">
                                   
                                    @csrf
                                    @method('DELETE')
                                    <div class="p-3">Are you sure you want to delete this room?</div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                        {{-- View a room  --}}
                        <div class="modal fade" id="viewRoom{{ $room->id }}" tabindex="-1" aria-labelledby="ViewRoomModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewRoomModalLabel">Room <b>{{$room->name}}</b></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="d-flex px-3">
                                        <div class="w-100 text-start text-primary">
                                            <p><b>ID: </b></p>
                                            <p><b>Room Title: </b></p>
                                            <p><b>Belone to: </b></p>
                                        </div>
                                        <div class="w-100 text-start">
                                            <p>{{$room->id}}</p>
                                            <p>{{$room->name}}</p>
                                            <p>{{$room->building }}</p>
                                           
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- {{ Edit Room pop up}} --}}
                        <div class="modal fade" id="editRoom{{$room->id}}" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="editRoomModalLabel">Edit Room Inventory</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('rooms.update',$room->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="mb-3">
                                                <label class="form-label">Room Title</label>
                                                <input type="text" name="name" value="{{ $room->name }}" class="form-control" placeholder="Room title">
                                            </div>
                                            <div class="mb-3 d-flex flex-column">
                                                <label class="form-label">Building Title</label> 
                                                <select name="building_id" class="p-2 rounded-2">
                                                    @foreach ($buildings as $build )
                                                    <option value={{$build->id}} {{$room->building_id == $build->id ? 'selected' : ''}} >{{$build->building}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bx bx-log-out-circle"></i> Cancel</button>
                                                <button type="submit" class="btn btn-primary ml-3"><i class="bx bx-save"></i>Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
                            </div>
                        </div>
                        
                    </td>                   
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {!! $rooms->links() !!}
</div>

{{-- Addnew Building pop up --}}
<div class="modal fade" id="addnewRoom" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="roomModalLabel">Add New Building</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label class="form-label">Room Title</label>
                        <input type="text" name="name" class="form-control" placeholder="Room">
                    </div>
                    <div class="mb-3 d-flex flex-column">
                        <label class="form-label">Building Title</label>
                        <select name="building_id" class="p-2 rounded-2">
                            @foreach ($buildings as $build )
                            <option value={{$build->id}}>{{$build->building}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bx bx-log-out-circle"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary ml-3"><i class="bx bx-save"></i>Save</button>
                    </div>
                </div>
            </form>
        </div>
   
      </div>
    </div>
  </div>

@endsection
