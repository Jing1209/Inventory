@extends('layouts.app')
@section('title', 'Sponsor')
@section('content')
{{-- Header  --}}
<div class="container text-center">
    <h2 class="modal-title p-2" id="buildingModalLabel">Sponsor Inventory</h2>
</div>
<div style="position: sticky;padding: 10px 0px 0 0px; top: 60px; overflow: hidden;background: #e4e9f7;" class="d-flex justify-content-between mb-3">
    <div class="w-25 d-flex justify-content-start text-white bg-primary rounded-2 me-2">
        <i class='bx bx-dollar-circle my-4 ms-3 d-flex align-items-center p-2 rounded-2' style="background-color: rgba(255, 255, 255, 0.16); font-size: 20px;"></i>
        <div class="mx-3 my-3">
            Total Sponsor
            <div>
                {{$countSponsor}}
            </div>
        </div>
    </div>
    <div class=" w-75 d-flex align-items-center text-white bg-white rounded-2 me-2 px-3">
        <div class="d-flex w-100 justify-content-between">
            {{-- search bar --}}
            <form class="w-50" action="{{ route('sponsor.index') }}" method="GET" role="search">
                <div class="d-flex justify-content-start">
                    <div class="input-group">
                        <input type="text" class="form-control mr-2 w-100 ps-3" name="term" placeholder="Search Sponsor" id="term">
                    </div>
                    <span class="input-group-btn ms-2">
                        <button class="btn btn-primary d-flex align-items-center h-100" type="submit" title="Search Sponsor">
                            <i style=" font-size: 18px;" class='bx bx-search'></i>
                        </button>
                    </span>
                </div>
            </form>
            <div>
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addnewSponsor"><i style="font-size: 18px;" class="bx bx-plus me-2"></i>Add New</button>
            </div>
        </div>
    </div>
</div>

{{-- Sponsor Table  --}}

<div class="mt-1 rounded bg-white">
    <table class="table table-striped table-hover" id="myTable">
        <thead>
            <tr class="table-primary">
                <th scope="col" style="padding-left: 20px;">S.No</th>
                <th scope="col">Title/Name</th>
                <th scope="col" style="width: 200px; text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sponsors as $sponsor)
            <tr>
                <td style="padding-left: 20px;">{{ $sponsor->id }}</td>
                <td>{{ $sponsor->name}}</td>
                <td style="text-align: center;">
                    <a href="#editSponsor{{$sponsor->id}}" data-bs-toggle="modal" class="btn btn-primary">Edit</a>
                    <a href="#deleteClarify{{$sponsor->id}}" data-bs-toggle="modal" class="btn btn-danger">Delete</a>

                    {{-- Comfirm Delete Building  --}}
                    <div class="modal fade" id="deleteClarify{{$sponsor->id}}" tabindex="-1" aria-labelledby="deleteBuildingModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteBuildingModalLabel">Confirm Message</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('sponsor.destroy',$sponsor->id) }}" method="Post">

                                    @csrf
                                    @method('DELETE')
                                    <div class="p-3">Are you sure you want to delete this Sponsor?</div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    {{-- {{ Edit pop up}} --}}
                    <div class="modal fade" id="editSponsor{{$sponsor->id}}" tabindex="-1" aria-labelledby="editSponsorModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editSponsorModalLabel">Edit Sponsor Inventory</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('sponsor.update',$sponsor->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row p-3">
                                        <div class="mb-3">
                                            <label class="form-label">Sponsor Title</label>
                                            <input type="text" name="name" value="{{ $sponsor->name }}" class="form-control" placeholder="Title">
                                            @error('building')
                                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                            @enderror
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
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    
</div>
<div class="d-flex justify-content-center">
    {!! $sponsors->links() !!}
</div>

{{-- Addnew Building pop up --}}
<div class="modal fade" id="addnewSponsor" tabindex="-1" aria-labelledby="sponsorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sponsorModalLabel">Add New Building</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sponsor.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Sponsor Title</label>
                        <input type="text" class="form-control" name="name">
                        @error('name')
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