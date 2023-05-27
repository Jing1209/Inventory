@extends('layouts.app')
@section('title')
    Item
@endsection

@section('content')
    <div class="container-lg my-4 rounded bg-light">
        <div class="row">
            <div class=" mt-4 d-flex justify-content-center">
                <h2>Add New Item</h2>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1">
                {{ session('status') }}
            </div>
        @endif
        <div class="p-4">
            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-5">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group mb-3">
                            @if($errors->has('item_id'))
                                <div class="error text-danger">{{ $errors->first('item_id') }}</div>
                            @endif
                            <strong>Item ID:</strong>
                            <input type="text" name="item_id" class="form-control" placeholder="ID">
                        </div>
                        <div class="form-group mb-3">
                            <strong>Item Name:</strong>
                            <input type="text" name="title" class="form-control" placeholder="Item">
                        </div>
                        <div class="d-flex row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 d-flex flex-column mb-3">
                                <strong>Price:</strong>
                                <input type="text" name="price" class="form-control" placeholder="Price">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 d-flex flex-column mb-3">
                                <strong>Status:</strong>
                                <select name="status" class="p-2 rounded-2">
                                    @foreach ($status as $stat)
                                        <option value={{ $stat->id }}>{{ $stat->status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 d-flex flex-column mb-3">
                                <strong>Category:</strong>
                                <select name="category_id" class="p-2 rounded-2">
                                    @foreach ($categories as $cate)
                                        <option value={{ $cate->id }}>{{ $cate->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 d-flex flex-column mb-3">
                                <strong>Sponsor by:</strong>
                                <select name="sponsored" class="p-2 rounded-2">
                                    @foreach ($sponsor as $spon)
                                        <option class="" value={{ $spon->id }}>{{ $spon->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <strong>Description:</strong>
                            <input type="text" name="description" class="form-control" placeholder="Description">
                        </div>
                    </div>


                    <div class="d-flex justify-content-center col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-center mt-3">
                                <input type="file" name="images" id="actual-btn" onchange="loadFile(event)" hidden>
                                <label style="cursor: pointer;" class="btn btn-outline-primary" for="actual-btn">Choose
                                    File</label>
                                <span id="file-chosen" class="py-2 ps-2">No file chosen</span>
                            </div>
                            <div class="mt-2 border">
                                <img id="output" width="400" height="300"
                                    src="{{ asset('images/default-image.png') }}" />
                            </div>
                            <div class="d-flex justify-content-end mt-3 mb-5">
                                <a class="btn btn-danger" href="{{ route('items.index') }}" enctype="multipart/form-data">
                                    Back
                                </a>
                                <button type="submit" class="btn btn-success ms-2">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>


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
