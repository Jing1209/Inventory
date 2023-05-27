@extends('layouts.app')
@section('title', 'Employee')
@section('content')
<div class="container text-center">
    <h2 class="modal-title p-2" id="buildingModalLabel">Employee Inventory</h2>
</div>
    <div style="position: sticky;padding: 10px 0px 0 0px; top: 60px; overflow: hidden;background: #e4e9f7;"
        class="d-flex justify-content-between mb-3">
        <div class="w-25 d-flex justify-content-start text-white bg-primary rounded-2 me-2">
            <div class="text-white"> <i class='bx bxs-group p-2 m-3 rounded-2'
                    style="background-color: rgba(255, 255, 255, 0.16); font-size: 18px;"></i></div>
            <div class="m-3">
                All Employees
                <div>
                    {{ $count }}
                </div>
            </div>
        </div>
        <div class=" w-75 d-flex align-items-center text-white bg-white rounded-2 me-2">
            <div class="d-flex w-100 justify-content-between px-3">
                {{-- search bar --}}
                <form class="w-50" action="{{ route('employees.index') }}" method="GET" role="search">
                    <div class="d-flex justify-content-start">
                        <div class="input-group">
                            <input type="text" class="form-control mr-2 w-100 ps-3" name="term"
                                placeholder="Search Employee" id="term">
                        </div>
                        <span class="input-group-btn ms-2">
                            <button class="btn btn-primary d-flex align-items-center h-100" type="submit"
                                title="Search Employee">
                                <i style=" font-size: 18px;" class='bx bx-search'></i>
                            </button>
                        </span>
                    </div>
                </form>
                <a class="text-white text-decoration-none" href="{{ route('employees.create') }}">
                    <div class="btn btn-primary d-flex justify-conten-between">
                        <div class="me-2 d-flex align-items-center">
                            <i style="font-size: 18px;" class='bx bx-plus text-white'></i>
                        </div>
                        <span>Add New</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="mt-1 rounded bg-white">
        <div class="row">
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table table-striped table-hover">
            <thead>
                <tr class="table-primary">
                    <th scope="col" style="padding-left: 20px;">S.No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col" style="width: 200px; text-align: center;">Action</th>  
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td scope="row" style="padding-left: 20px;">{{ $employee->id }}</td>
                        <td>{{ $employee->firstname }} {{ $employee->lastname }}</td>
                        <td>{{ $employee->gender }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->phone_number }}</td> 
                        <td style="text-align: center;">
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="Post">
                                <a class="btn btn-warning text-white" href="#viewEmployee{{ $employee->id }}" data-bs-toggle="modal">View</a>
                                <a class="btn btn-primary" href="{{ route('employees.edit', $employee->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <a href="#deleteClarify{{ $employee->id }}" data-bs-toggle="modal" class="btn btn-danger">
                                    Delete
                                </a>
                                {{-- Comfirm Delete Room  --}}
                                <div class="modal fade" id="deleteClarify{{ $employee->id }}" tabindex="-1"
                                    aria-labelledby="deleteBuildingModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteBuildingModalLabel">Confirm Message
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('employees.destroy', $employee->id) }}" method="Post">

                                                @csrf
                                                @method('DELETE')
                                                <div class="p-3">Are you sure you want to delete this employee?</div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            {{-- View an employee  --}}
                            <div class="modal fade" id="viewEmployee{{ $employee->id }}" tabindex="-1" aria-labelledby="ViewEmployeeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewItemModalLabel">Employee</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="d-flex px-3">
                                            <div class="w-100 text-start text-primary">
                                                <p><b>ID: </b></p>
                                                <p><b>Name: </b></p>
                                                <p><b>Gender: </b></p>
                                                <p><b>Email: </b></p>
                                                <p><b>Phone Number: </b></p>
                                                <p><b>Created At: </b></p>
                                            </div>
                                            <div class="w-100 text-start">
                                                <p>{{$employee->id}}</p>
                                                <p>{{$employee->firstname}} {{$employee->lastname}}</p>
                                                <p>{{$employee->gender}}</p>
                                                <p>{{$employee->email}}</p>
                                                <p>{{$employee->phone_number}}</p>
                                                <p>{{$employee->created_at}}</p>
                                            </div> 
                                            <div class="w-100 d-flex align-items-center text-start">
                                                 <img id="output" width="300" height="200" src="{{ url('public/Image/'.$employee->url) }}" />
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {!! $employees->links() !!}
</div>
@endsection
