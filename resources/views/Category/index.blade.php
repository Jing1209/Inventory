@extends('layouts.app')
@section('title', 'Category')
@section('content')
<div class="container text-center">
    <h2 class="modal-title p-2" id="buildingModalLabel">Category Inventory</h2>
</div>
<div style="position: sticky;padding: 10px 0px 0 0px; top: 60px; overflow: hidden;background: #e4e9f7;" class="d-flex justify-content-between mb-3">
    <div class="w-25 d-flex justify-content-start text-white bg-primary rounded-2 me-2">
        <div class="text-white "> <i class='bx bxs-briefcase p-2 m-3 rounded-2' style="background-color: rgba(255, 255, 255, 0.16); font-size: 18px;"></i></div>
        <div class="mx-3 my-3">
            All Category
            <div>
                234
            </div>
        </div>
    </div>
    <div class=" w-75 d-flex align-items-center text-white bg-white rounded-2 me-2 px-3">
        <div class="d-flex w-100 justify-content-between">
            {{-- search bar --}}
            <form class="w-50" action="{{ route('categories.index') }}" method="GET" role="search">
                <div class="d-flex justify-content-start">
                    <div class="input-group">
                        <input type="text" class="form-control mr-2 w-100 ps-3" name="term" placeholder="Search Category" id="term">
                    </div>
                    <span class="input-group-btn ms-2">
                        <button class="btn btn-primary d-flex align-items-center h-100" type="submit" title="Search Category">
                            <i style=" font-size: 18px;" class='bx bx-search'></i>
                        </button>
                    </span>
                </div>
            </form>
            <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addnewCategory"><i style="font-size: 18px;" class="bx bx-plus me-2"></i>Add New</button>
        </div>
    </div>
</div>
<div class="mt-1 rounded bg-white">
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" >
        <span>{{ $message }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="mt-1 rounded bg-white">
        <table class="table table-striped table-hover" id="myTable">
            <thead class="border-bottom">
                <tr class="table-primary">
                    <th class="col" style="padding-left: 20px;">S.No</th>
                    <th class="col">Category Name</th>
                    <th class="col">Quantity</th>
                    <th class="col" style="width: 200px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td style="padding-left: 20px;">{{ $category->id }}</td>
                    <td>{{ $category->category }}</td>
                    <td>{{ $category->quantity }}</td>
                    <td style="text-align: center;">
                        <a href="#editCategory{{$category->id}}" data-bs-toggle="modal" class="btn btn-primary">Edit</a>
                        <a href="#deleteClarify{{$category->id}}" data-bs-toggle="modal" class="btn btn-danger">Delete</a> 
                        
                         {{-- Comfirm Delete Building  --}}
                        <div class="modal fade" id="deleteClarify{{$category->id}}" tabindex="-1" aria-labelledby="deleteBuildingModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="deleteBuildingModalLabel">Confirm Message</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('categories.destroy',$category->id) }}" method="Post">
                                    @csrf
                                    @method('DELETE')
                                    <div class="p-3">Are you sure you want to delete this category?</div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                      </div>
                                </form>
                            
                            </div>
                            </div>
                        </div>
                        <!-- Edit category -->
                        <div class="modal fade" id="editCategory{{$category->id}}" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCategoryModalLabel">Edit Catogory</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('categories.update',$category->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row p-3">
                                            <div class="mb-3">
                                                <label class="form-label">Cateory Title</label>
                                                <input type="text" name="category" value="{{ $category->category }}" class="form-control" placeholder="Category Title">
                                                @error('category')
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
</div>
<div class="d-flex justify-content-center">
    {!! $categories->links() !!}
</div>

<!-- Add new category -->
<div class="modal fade" id="addnewCategory" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Category Title</label>
                        <input type="text" class="form-control" name="category">
                        @error('category')
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