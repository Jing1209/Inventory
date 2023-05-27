@extends('layouts.app')
@section('title', 'Building')
@section('content')
<div class="container text-center">
    <h2 class="modal-title p-2" id="buildingModalLabel">Building Inventory</h2>
</div>
<div style="position: sticky;padding: 10px 0px 0 0px; top: 60px; overflow: hidden;background: #e4e9f7;" class="d-flex justify-content-between mb-3">
    
    <div class="w-25 d-flex justify-content-start text-white bg-primary rounded-2 me-2">
        <div class="mx-3 my-3">
            Total Building
            <div>
                {{$countBuilding}}
            </div>
        </div>
    </div>
    <div class=" w-75 d-flex align-items-center text-white bg-white rounded-2 me-2">
        <div class="d-flex w-100 justify-content-between">
            {{-- search bar --}}
            <form class="ms-5 w-50" action="{{ route('buildings.index') }}" method="GET" role="search">
                <div class="d-flex justify-content-start">
                    <div class="input-group">
                        <input type="text" class="form-control mr-2 w-100 ps-3" name="term" placeholder="Search Building" id="term">
                    </div>
                    <span class="input-group-btn ms-2">
                        <button class="btn btn-primary d-flex align-items-center h-100" type="submit" title="Search Building">
                            <i style=" font-size: 18px;" class='bx bx-search'></i>
                        </button>
                    </span>
                </div>
            </form>
            <div class="me-3">
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addnewBuilding"><i class="bx bx-plus me-2" style="font-size: 18px;"></i>Add New</button>
            </div>
        </div>
    </div>
</div>

{{-- {{Table}} --}}
<div class="mt-1 rounded bg-white">
    <table class="table table-striped table-hover">
        <thead class="border-bottom">
            <tr class="table-primary">
                <th class="col">S.No</th>
                <th class="col">Building Title</th>
                <th class="col" style="width: 200px; text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($buildings as $building)
            <tr>
                <td scope="col" style="padding-left: 20px;">{{ $building->id }}</td>
                <td>{{ $building->building }}</td>
                <td>
                    <form action="{{ route('buildings.destroy',$building->id) }}" method="Post">
                        <a href="#editBuilding{{$building->id}}" data-bs-toggle="modal" class="btn btn-primary">Edit</a>
                        @csrf
                        @method('DELETE')
                        <a href="#deleteClarify{{$building->id}}" data-bs-toggle="modal" class="btn btn-danger">
                            Delete
                        </a>
                        {{-- Comfirm Delete Room  --}}
                        <div class="modal fade" id="deleteClarify{{$building->id}}" tabindex="-1" aria-labelledby="deleteBuildingModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteBuildingModalLabel">Confirm Message</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('buildings.destroy',$building->id) }}" method="Post">

                                        @csrf
                                        @method('DELETE')
                                        <div class="p-3">Are you sure you want to delete this buidling?</div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- {{ Edit pop up}} --}}
                    <div class="modal fade" id="editBuilding{{$building->id}}" tabindex="-1" aria-labelledby="editBuildingModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editBuildingModalLabel">Edit Buildnig Inventory</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('buildings.update',$building->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row p-3">
                                        <div class="mb-3">
                                            <label class="form-label">Building Title</label>
                                            <input type="text" name="building" value="{{ $building->building }}" class="form-control" placeholder="Building Title">
                                            @error('building')
                                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bx bx-log-out-circle"></i> Cancel</button>
                                        <button type="submit" class="btn btn-primary ml-3"><i class="bx bx-save"></i>Save</button>
                                    </div>
                                </form>
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
    {!! $buildings->links() !!}
</div>

{{-- Addnew Building pop up --}}
<div class="modal fade" id="addnewBuilding" tabindex="-1" aria-labelledby="buildingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buildingModalLabel">Add New Building</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('buildings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Building Title</label>
                        <input type="text" class="form-control" name="building">
                        @error('building')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bx bx-log-out-circle"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection