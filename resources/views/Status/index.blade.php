@extends('layouts.app')
@section('title', 'Building')
@section('content')
<div class="container text-center">
    <h2 class="modal-title p-2" id="buildingModalLabel">Status Inventory</h2>
</div>
<div style="position: sticky;padding: 10px 0px 0 0px; top: 60px; overflow: hidden;background: #e4e9f7;" class="d-flex justify-content-between mb-3">
    <div class="w-25 d-flex justify-content-start text-white bg-primary rounded-2 me-2">
        <i class='bx bxs-hourglass-top my-4 ms-3 d-flex align-items-center p-2 rounded-2' style="background-color: rgba(255, 255, 255, 0.16); font-size: 18px;"></i>
        <div class="mx-3 my-3">
            Total Status
            <div>
                {{$countStatus}}
            </div>
        </div>
    </div>
    <div class=" w-75 d-flex align-items-center text-white bg-white rounded-2 me-2 px-3">
        <div class="d-flex w-100 justify-content-between">
            {{-- search bar --}}
            <form class="w-50" action="{{ route('status.index') }}" method="GET" role="search">
                <div class="d-flex justify-content-start">
                    <div class="input-group">
                        <input type="text" class="form-control mr-2 w-100 ps-3" name="term" placeholder="Search Status" id="term">
                    </div>
                    <span class="input-group-btn ms-2">
                        <button class="btn btn-primary d-flex align-items-center h-100" type="submit" title="Search Status">
                            <i style=" font-size: 18px;" class='bx bx-search'></i>
                        </button>
                    </span>
                </div>
            </form>
            <div>
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addnewStatus"><i style="font-size: 18px;" class="bx bx-plus me-2"></i>Add New</button>
            </div>
        </div>
    </div>
</div>
<div class="mt-1 rounded bg-white">
    <table class="table table-striped table-hover">
        <thead>
            <tr class="table-primary">
                <th scope="col" style="padding-left: 20px;">S.No</th>
                <th scope="col">Status</th>
                <th scope="col" style="width: 200px; text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statuses as $status)
            <tr>
                <td style="padding-left: 20px;">{{ $status->id }}</td>
                <td>{{ $status->status }}</td>
                <td style="text-align: center;">
                    <a href="#editStatus{{$status->id}}" data-bs-toggle="modal" class="btn btn-primary">
                        Edit
                    </a>
                    <a href="#deleteClarify{{$status->id}}" data-bs-toggle="modal" class="btn btn-danger">Delete</a>

                    {{-- Comfirm Delete Building  --}}
                    <div class="modal fade" id="deleteClarify{{$status->id}}" tabindex="-1" aria-labelledby="deleteBuildingModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteBuildingModalLabel">Confirm Message</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('status.destroy',$status->id) }}" method="Post">

                                    @csrf
                                    @method('DELETE')
                                    <div class="p-3">Are you sure you want to delete this Status?</div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    {{-- {{ Edit pop up}} --}}
                    <div class="modal fade" id="editStatus{{$status->id}}" tabindex="-1" aria-labelledby="editStatus" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editStatusModalLabel">Edit Status Inventory</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('status.update',$status->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row p-3">
                                        <div class="mb-3">
                                            <label class="form-label">Status Title</label>
                                            <input type="text" name="status" value="{{ $status->status }}" class="form-control" placeholder="Building Title">
                                            @error('status')
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
    {!! $statuses->links() !!}
</div>
{{-- Addnew status pop up --}}
<div class="modal fade" id="addnewStatus" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Add New Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('status.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Status Title</label>
                        <input type="text" class="form-control" name="status">
                        @error('status')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bx bx-log-out-circle"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary ml-3"><i class="bx bx-save"></i>Save</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

@endsection