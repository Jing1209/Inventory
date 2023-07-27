@extends('layouts.app')
@section('title')
Employee
@endsection

@section('content')
<div style="height: 80vh;" class="m-3 mb-5 bg-white rounded-3">
    <form action="{{ route('employees.update',$employee->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="d-flex justify-content-around">
            <div class="row m-5">
                <div class="d-flex justify-content-center">
                    <div class="d-flex justify-content-start">
                        <i style="font-size: 30px;" class='bx bxs-user'></i>
                        <h3 class="ms-3">Update Employee!</h3>
                    </div>
                </div>
                <div class="my-2">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Firstname:</strong>
                            <input type="text" name="firstname" class="form-control" placeholder="Firstname" value="{{$employee->firstname}}">
                            {{-- @error('name')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                        </div>
                        @enderror --}}
                    </div>
                </div>
                <div class="my-2">
                    <div class="form-group">
                        <strong>Lastname:</strong>
                        <input type="text" name="lastname" class="form-control" placeholder="Lastname" value="{{$employee->lastname}}">
                    </div>
                </div>
                <div class="mb-2">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" class="form-select" id="">
                            @if($employee->gender=="Female")
                            <option value="{{$employee->gender}}">{{$employee->gender}}</option>
                            <option value="Male">Male</option>
                            @elseif($employee->gender=="Male")
                            <option value="{{$employee->gender}}">{{$employee->gender}}</option>
                            <option value="Female">Female</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="my-2">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{$employee->email}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Phone Number:</strong>
                        <input type="number" name="phone_number" class="form-control" placeholder="Phone number" value="{{$employee->phone_number}}">
                    </div>
                </div>
                <div class="my-3 d-flex flex-row-reverse">
                    <button type="submit" class="btn btn-primary ms-2"><i class="bx bx-save pe-1"></i>Confirm</button>
                    <a class="btn btn-secondary" href="{{ route('employees.index') }}"> Back</a>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column me-5">
            <div style="margin-top: 100px;" class="border text-center">
                @foreach ($image as $image1)
                <img id="output" width="400" height="300" src="{{ url('public/Image/'.$image1->url) }}" alt="">
                @endforeach
            </div>
            <div class="d-flex my-3">
                <input type="file" name="images" id="actual-btn" onchange="loadFile(event)" hidden>
                <label style="cursor: pointer;" class="bg-success text-white p-2 rounded text-center" for="actual-btn">Choose File</label>
                <div style="width: 400px;" id="file-chosen" class="py-2 ps-2">No file chosen</div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    var fileChosen = document.getElementById('file-chosen');
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
        fileChosen.textContent = event.target.files[0].name
    };
</script>
@endsection