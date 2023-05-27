@extends('layouts.app')
@section('title')
Employee
@endsection

@section('content')
<div style="height: 80vh;" class="m-3 mb-5 bg-white rounded-3">
    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="d-flex justify-content-around">
            <div class="row m-5">
                <div class="d-flex justify-content-center">
                    <div class="d-flex justify-content-start">
                        <i style="font-size: 30px;" class='bx bxs-user'></i>
                        <h3 class="ms-3">Create New Employee!</h3>
                    </div>
                </div>
                <div class="my-2">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="firstname">Firstname</label>
                            <input type="text" name="firstname" class="form-control" placeholder="Input employee firstname">
                            {{-- @error('name')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                        </div>
                        @enderror --}}
                    </div>
                </div>
                <div class="my-2">
                    <div class="form-group">
                        <label for="lastname">Lastname</label>
                        <input type="text" name="lastname" class="form-control" placeholder="Input employee lastname">
                    </div>
                </div>
                <div class="mb-2">
                    <label for="gender">Gender</label>
                    <select  class="form-select" name="gender" id="">
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>
                    </select>
                </div>
                <div class="mb-2">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="user@gmail.com">
                    </div>
                </div>
                <div class="mb-2">
                    <div class="form-group">
                        <label for="phone-number">Phone number</label>
                        <input type="number" name="phone_number" class="form-control" placeholder="087 xxxxxx32">
                    </div>
                </div>
                <div class="my-3 d-flex flex-row-reverse">
                    <button type="submit" class="btn btn-primary ms-2"><i class="bx bx-save pe-1"></i>Save</button>
                    <a class="btn btn-secondary" href="{{ route('employees.index') }}"> Back</a>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column me-5">
            <div style="margin-top: 100px;" class="border text-center">
                <img id="output" width="400" height="300" src="{{ asset('images/user.png') }}" />
            </div>
            <div class="d-flex my-3">
                <input type="file" name="images" id="actual-btn" onchange="loadFile(event)" hidden>
                <label style="cursor: pointer;" class="bg-success text-white p-2 rounded text-center" for="actual-btn">Choose File</label>
                <div id="file-chosen" class="py-2 ps-2" style="width: 400px;">No file chosen</div>
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