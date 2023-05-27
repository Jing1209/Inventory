@extends('layouts.app')
@section('title', 'Department')
@section('content')
<div class="container text-center">
    <h2 class="modal-title p-2" id="departmentModalLabel">Department Inventory</h2>
</div>
<div style="position: sticky;padding: 10px 0px 0 0px; top: 60px; overflow: hidden;background: #e4e9f7;" class="d-flex justify-content-between mb-3">
    
    <div class="w-25 d-flex justify-content-start text-white bg-primary rounded-2 me-2">
        <div class="mx-3 my-3">
            Total Department
            <div>
                {{$countDepartment}}
            </div>
        </div>
    </div>
    <div class=" w-75 d-flex align-items-center text-white bg-white rounded-2 me-2">
        <div class="d-flex w-100 justify-content-between">
            {{-- search bar --}}
            <form class="ms-5 w-50" action="{{ route('departments.index') }}" method="GET" role="search">
                <div class="d-flex justify-content-start">
                    <div class="input-group">
                        <input type="text" class="form-control mr-2 w-100 ps-3" name="term" placeholder="Search Department" id="term">
                    </div>
                    <span class="input-group-btn ms-2">
                        <button class="btn btn-primary d-flex align-items-center h-100" type="submit" title="Search Department">
                            <i style=" font-size: 18px;" class='bx bx-search'></i>
                        </button>
                    </span>
                </div>
            </form>
            <div class="me-3">
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addnewdepartment"><i class="bx bx-plus me-2" style="font-size: 18px;"></i>Add New</button>
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
                <th class="col">Department Title</th>
                <th class="col" style="width: 200px; text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
            <tr>
                <td scope="col" style="padding-left: 20px;">{{ $department->id }}</td>
                <td>{{ $department->Department }}</td>
                <td>
                    <form action="{{ route('departments.destroy',$department->id) }}" method="Post">
                        <a href="#editDepartment{{$department->id}}" data-bs-toggle="modal" class="btn btn-primary">Edit</a>
                        @csrf
                        @method('DELETE')
                        <a href="#deleteClarify{{$department->id}}" data-bs-toggle="modal" class="btn btn-danger">
                            Delete
                        </a>
                        {{-- Comfirm Delete Room  --}}
                        <div class="modal fade" id="deleteClarify{{$department->id}}" tabindex="-1" aria-labelledby="deleteDepartmentModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteDepartmentModalLabel">Confirm Message</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('departments.destroy',$department->id) }}" method="Post">

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
                    <div class="modal fade" id="editDepartment{{$department->id}}" tabindex="-1" aria-labelledby="editDepartmentModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editDepartmentModalLabel">Edit Buildnig Inventory</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('departments.update',$department->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row p-3">
                                        <div class="mb-3">
                                            <label class="form-label">Department Title</label>
                                            <input type="text" name="department" value="{{ $department->department }}" class="form-control" placeholder="Department Title">
                                            @error('department')
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
    {!! $departments->links() !!}
</div>

{{-- Addnew department pop up --}}
<div class="modal fade" id="addnewdepartment" tabindex="-1" aria-labelledby="departmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="departmentModalLabel">Add New department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('departments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">department Title</label>
                        <input type="text" class="form-control" name="department">
                        @error('department')
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