@extends('layouts.app')
@section('title', 'Transaction')
@section('content')
    <div class="container text-center">
        <h2 class="modal-title p-2" id="buildingModalLabel">Transaction Inventory</h2>
    </div>
    <div style="position: sticky ;padding: 10px 0px 0 0px; top: 60px; overflow: hidden;"
        class="d-flex justify-content-between mb-3 p-2 bg-white rounded-2">
        <div class="w-100 d-flex align-items-center justify-content-start text-white bg-primary rounded-2 me-2">
            <i class='bx bx-archive-out p-2 m-3 rounded-2'
                style="background-color: rgba(255, 255, 255, 0.16); font-size: 18px;"></i>
            <div class="mx-3 my-3">
                Borrow
                <div>
                    {{ $countBorrow }}
                </div>
            </div>
        </div>
        <div class="w-100 d-flex align-items-center text-white bg-success rounded-2 me-2">
            <i class='bx bx-archive-in p-2 m-3 rounded-2'
                style="background-color: rgba(255, 204, 145, 0.16); font-size: 18px;"></i>
            <div class="mx-3 my-2">
                Return
                <div>
                    {{ $countReturn }}
                </div>
            </div>

        </div>
        <div class="w-100 me-2 d-flex align-items-center justify-content-end text-white rounded-2">
            <a class="text-white text-decoration-none" href="{{ route('download-pdf') }}">
                <div class="btn btn-info d-flex justify-conten-between text-white me-2">
                    <div class="me-2 d-flex align-items-center">
                        <i style="font-size: 18px;" class='bx bx-export '></i>
                    </div>
                    <span>Export</span>
                </div>
            </a>
            <button type="button" class="btn btn-primary d-flex align-items-center rounded d-flex justify-conten-between"
                data-bs-toggle="modal" data-bs-target="#addNewTransaction">
                <div class="d-flex align-items-center me-2">
                    <i style="font-size: 18px;" class='bx bx-plus text-white'></i>
                </div>
                <span>Add New</span>
            </button>
        </div>
    </div>
    <div class="bg-white rounded">
        <div class="mt-2">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <!-- <div class="my-3 py-2">
                <form action="/search" method="POST" role="search">
                    {{ csrf_field() }}
                    <div class="mx-4">
                        <div class="row">
                            <div class="col-6">
                                <select class="form-control" name="status">
                                    <option value="">Filter by Status</option>
                                    <option value="Returned">Returned</option>
                                    <option value="Borrowed">Borrowed</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-sm text-uppercase font-semibold mt-1 "
                                    style="background-color: #0d5eff; min-height: 32px">Choose category
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div> -->

            <table class="table table-striped table-hover" id="myTable">
                <thead class="border-bottom">
                    <tr class="table-primary">
                        <th style="padding-left: 20px;">S.No</th>
                        <th>Item</th>
                        <th>Room</th>
                        <th>Condition</th>
                        <th>Borrowed by</th>
                        <th>Status</th>
                        <th>Borrowed date</th>
                        <th>Returned Date</th>
                        <th scope="col" style="width: 200px; text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $keys => $transaction)
                        <tr>
                            <td style="padding-left: 20px;">{{ $keys + 1 }}</td>
                            <td>{{ $transaction->ItemName }}</td>
                            <td>{{ $transaction->BuildingName }}-{{ $transaction->RoomName }}</td>
                            <td>{{ $transaction->ConditionName }}</td>
                            <td>{{ $transaction->EmployeeFirstname }} {{ $transaction->EmployeeLastname }}</td>
                            <td>{{ $transaction->status }}</td>
                            <td>{{ $transaction->created_at }}</td>
                            <td>
                                @if ($transaction->returned_date == '')
                                    <span class="text-danger">Not yet Return</span> 
                                @else
                                    {{ $transaction->returned_date }}
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if ($transaction->status == 'Returned')
                                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="Post">
                                        <a class="btn btn-warning text-white" href="#viewTransaction{{ $transaction->id }}"
                                            data-bs-toggle="modal"><i class="bx bx-show"></i></a>
                                        <a class="btn btn-primary" href="#editTransaction{{ $transaction->id }}"
                                            data-bs-toggle="modal"><div class="bx bx-pencil"></div></a>
                                        @csrf
                                        @method('DELETE')
                                        <a href="#deleteClarify{{ $transaction->id }}" data-bs-toggle="modal"
                                            class="btn btn-danger">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                        {{-- Comfirm Delete Room  --}}
                                        <div class="modal fade" id="deleteClarify{{ $transaction->id }}" tabindex="-1"
                                            aria-labelledby="deleteBuildingModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteBuildingModalLabel">Confirm
                                                            Message</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                                        method="Post">

                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="p-3">Are you sure you want to delete this
                                                            transaction?</div>
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
                                    {{-- View an Transaction  --}}
                                    <div class="modal fade" id="viewTransaction{{ $transaction->id }}" tabindex="-1"
                                        aria-labelledby="ViewTransactionModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewTransactionModalLabel">Transaction for
                                                        <b>{{ $transaction->ItemName }} Item</b>
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="d-flex px-3">
                                                    <div class="w-100 text-start text-primary">
                                                        <p><b>ID: </b></p>
                                                        <p><b>Item title: </b></p>
                                                        <p><b>Room: </b></p>
                                                        <p><b>Condition: </b></p>
                                                        <p><b>Borrowed by: </b></p>
                                                        <p><b>Status: </b></p>
                                                        <p><b>Borrowed At: </b></p>
                                                    </div>
                                                    <div class="w-100 text-start">
                                                        <p>{{ $transaction->id }}</p>
                                                        <p>{{ $transaction->ItemName }}</p>
                                                        <p>{{ $transaction->BuildingName }}-{{ $transaction->RoomName }}
                                                        </p>
                                                        <p>{{ $transaction->ConditionName }}</p>
                                                        <p>{{ $transaction->EmployeeFirstname }}
                                                            {{ $transaction->EmployeeLastname }}</p>
                                                        <p>{{ $transaction->status }}</p>
                                                        <p>{{ $transaction->created_at }}</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- {{ Edit pop up}} --}}
                                    <div class="modal fade" id="editTransaction{{ $transaction->id }}" tabindex="-1"
                                        aria-labelledby="editTransactionModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editTransactionModalLabel">Update
                                                        Transaction
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <form action="{{ route('transactions.update', $transaction->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="row">
                                                            <div class="mb-1 d-flex flex-column">
                                                                <label class="col-form-label d-flex">Item:</label>
                                                                <select name="item_id" class="p-2 rounded-2">
                                                                    @foreach ($items as $item)
                                                                        <option value={{ $item->id }}
                                                                            {{ $transaction->ItemId == $item->title ? 'selected' : '' }}>
                                                                            {{ $item->title }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="mb-1 d-flex flex-column">
                                                                <label class="col-form-label d-flex">Room: </label>
                                                                <select name="room_id" class="p-2 rounded-2">
                                                                    @foreach ($rooms as $cate)
                                                                        <option value={{ $cate->id }}
                                                                            {{ $transaction->BuildingId == $cate->id ? 'selected' : '' }}>
                                                                            {{ $cate->building }}-{{ $cate->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-1 d-flex flex-column">
                                                                <label
                                                                    class="col-form-label d-flex text-right">User:</label>
                                                                <select name="employee_id" class="p-2 rounded-2">
                                                                    @foreach ($employees as $employee)
                                                                        <option value={{ $employee->id }}
                                                                            {{ $transaction->EmployeeId == $employee->id ? 'selected' : '' }}>
                                                                            {{ $employee->firstname }}
                                                                            {{ $employee->lastname }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-1 d-flex flex-column">
                                                                <label
                                                                    class="col-form-label d-flex text-right">Status:</label>
                                                                <select name="status" class="p-2 rounded-2">
                                                                    @foreach ($statuses as $stat)
                                                                        <option value="{{ $stat->id }}"
                                                                            {{ $transaction->ConditionId == $stat->status ? 'selected' : '' }}>
                                                                            {{ $stat->status }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal"><i
                                                                        class="bx bx-log-out-circle"></i>
                                                                    Cancel</button>
                                                                <button type="submit" class="btn btn-primary"><i
                                                                        class="bx bx-save"></i> Confirm</button>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <form action="/returned/{{ $transaction->id }}" method="Post">
                                        @csrf
                                        @method('PUT')
                                        <a href="#deleteClarify{{ $transaction->id }}" data-bs-toggle="modal"
                                            class="btn btn-primary">
                                            <i class="bx bx-check"></i>
                                        </a>
                                        {{-- Comfirm Delete Room  --}}
                                        <div class="modal fade" id="deleteClarify{{ $transaction->id }}" tabindex="-1"
                                            aria-labelledby="statusBuildingModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="statsuBuildingModalLabel">Confirm
                                                            Message</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                                        method="Post">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="p-3">Are this transaction is returned?</div>
                                                        <input type="text" hidden name="status" value="Returned" />
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Return</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="Post">
                                        <a class="btn btn-warning text-white"
                                            href="#viewTransaction{{ $transaction->id }}" data-bs-toggle="modal"><i class="bx bx-show"></i></a>
                                        <a class="btn btn-primary" href="#editTransaction{{ $transaction->id }}"
                                            data-bs-toggle="modal"><i class="bx bx-pencil"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <a href="#deleteClarify{{ $transaction->id }}" data-bs-toggle="modal"
                                            class="btn btn-danger">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                        {{-- Comfirm Delete Room  --}}
                                        <div class="modal fade" id="deleteClarify{{ $transaction->id }}" tabindex="-1"
                                            aria-labelledby="deleteBuildingModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteBuildingModalLabel">Confirm
                                                            Message</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                                        method="Post">

                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="p-3">Are you sure you want to delete this
                                                            transaction?</div>
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
                                    {{-- View an Transaction  --}}
                                    <div class="modal fade" id="viewTransaction{{ $transaction->id }}" tabindex="-1"
                                        aria-labelledby="ViewTransactionModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewTransactionModalLabel">Transaction for
                                                        <b>{{ $transaction->ItemName }} Item</b>
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="d-flex px-3">
                                                    <div class="w-100 text-start text-primary">
                                                        <p><b>ID: </b></p>
                                                        <p><b>Item title: </b></p>
                                                        <p><b>Room: </b></p>
                                                        <p><b>Condition: </b></p>
                                                        <p><b>Borrowed by: </b></p>
                                                        <p><b>Status: </b></p>
                                                        <p><b>Borrowed At: </b></p>
                                                    </div>
                                                    <div class="w-100 text-start">
                                                        <p>{{ $transaction->id }}</p>
                                                        <p>{{ $transaction->ItemName }}</p>
                                                        <p>{{ $transaction->BuildingName }}-{{ $transaction->RoomName }}
                                                        </p>
                                                        <p>{{ $transaction->ConditionName }}</p>
                                                        <p>{{ $transaction->EmployeeFirstname }}
                                                            {{ $transaction->EmployeeLastname }}</p>
                                                        <p>{{ $transaction->status }}</p>
                                                        <p>{{ $transaction->created_at }}</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- {{ Edit pop up}} --}}
                                    <div class="modal fade" id="editTransaction{{ $transaction->id }}" tabindex="-1"
                                        aria-labelledby="editTransactionModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editTransactionModalLabel">Update
                                                        Transaction
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <form action="{{ route('transactions.update', $transaction->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="row">
                                                            <div class="mb-1 d-flex flex-column">
                                                                <label class="col-form-label d-flex">Item:</label>
                                                                <select name="item_id" class="p-2 rounded-2">
                                                                    @foreach ($items as $item)
                                                                        <option value={{ $item->id }}
                                                                            {{ $transaction->ItemId == $item->title ? 'selected' : '' }}>
                                                                            {{ $item->title }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="mb-1 d-flex flex-column">
                                                                <label class="col-form-label d-flex">Room: </label>
                                                                <select name="room_id" class="p-2 rounded-2">
                                                                    @foreach ($rooms as $cate)
                                                                        <option value={{ $cate->id }}
                                                                            {{ $transaction->BuildingId == $cate->id ? 'selected' : '' }}>
                                                                            {{ $cate->building }}-{{ $cate->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-1 d-flex flex-column">
                                                                <label
                                                                    class="col-form-label d-flex text-right">User:</label>
                                                                <select name="employee_id" class="p-2 rounded-2">
                                                                    @foreach ($employees as $employee)
                                                                        <option value={{ $employee->id }}
                                                                            {{ $transaction->EmployeeId == $employee->id ? 'selected' : '' }}>
                                                                            {{ $employee->firstname }}
                                                                            {{ $employee->lastname }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-1 d-flex flex-column">
                                                                <label
                                                                    class="col-form-label d-flex text-right">Status:</label>
                                                                <select name="status" class="p-2 rounded-2">
                                                                    @foreach ($statuses as $stat)
                                                                        <option value="{{ $stat->id }}"
                                                                            {{ $transaction->ConditionId == $stat->status ? 'selected' : '' }}>
                                                                            {{ $stat->status }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal"><i
                                                                        class="bx bx-log-out-circle"></i>
                                                                    Cancel</button>
                                                                <button type="submit" class="btn btn-primary"><i
                                                                        class="bx bx-save"></i> Confirm</button>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {!! $transactions->links() !!}
    </div>
    {{-- create transaction pop up --}}
    <div class="modal fade" id="addNewTransaction" tabindex="-1" aria-labelledby="TransactionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buildingModalLabel">Create Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-1 d-flex flex-column">
                                <label class="col-form-label d-flex">Item:</label>
                                <select name="item_id" class="p-2 rounded-2">
                                    @foreach ($items as $cate)
                                        <option value={{ $cate->id }}>{{ $cate->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-1 d-flex flex-column">
                                <label class="col-form-label d-flex">Room: </label>
                                <select name="room_id" class="p-2 rounded-2">
                                    @foreach ($rooms as $cate)
                                        <option value={{ $cate->id }}>{{ $cate->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-1 d-flex flex-column">
                                <label class="col-form-label d-flex">Building: </label>
                                <select name="building_id" class="p-2 rounded-2">
                                    @foreach ($buildings as $cate)
                                        <option value={{ $cate->id }}>{{ $cate->building }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-1 d-flex flex-column">
                                <label class="col-form-label d-flex text-right">User:</label>
                                <select name="employee_id" class="p-2 rounded-2">
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->firstname }}
                                            {{ $employee->lastname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-1 d-flex flex-column">
                                <label class="col-form-label d-flex text-right">Status:</label>
                                <select name="status" class="p-2 rounded-2">
                                    @foreach ($statuses as $stat)
                                        <option value="{{ $stat->id }}">{{ $stat->status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                        class="bx bx-log-out-circle"></i> Cancel</button>
                                <button type="submit" class="btn btn-primary ml-3"><i class="bx bx-save"></i>
                                    Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    $(document).ready(function () {
    $('#dataTable').DataTable({
        columnDefs: [
            {
                targets: [0],
                orderData: [0, 1],
            },
            {
                targets: [1],
                orderData: [1, 0],
            },
            {
                targets: [4],
                orderData: [4, 0],
            },
        ],
    });
});
</script>
