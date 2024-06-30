@extends('layouts.master')

@section('page-header')
@section('PageTitle')
    Advanced Users
@stop
@endsection

@section('content')
 
<style>
    .styled-table {
        width: 80%;
        text-align: center;
        margin-top: 10%;
        margin-left: 10%;
        vertical-align: middle;
    }

    .styled-table th,
    .styled-table td {
        border: none;
        padding: 10px;
        text-align: center;
        width: auto;
    }

    .styled-table th {
        background-color: #292D3D;
        color: #FFFFFF;
        text-align: center;
        padding-left: 20px;
        vertical-align: middle;
    }

    .styled-button {
        position: absolute;
        width: 400px;
        height: 60px;
        left: 800px;
        top: 0px;
        font-family: 'Inter';
        font-style: normal;
        font-weight: 800;
        font-size: 25px;
        line-height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        text-transform: uppercase;
        color: #FFFFFF;
        background-color: #FF7B1C;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 0px 0px 30px 30px;
        border: none;
        cursor: pointer;
        font-size: large;
    }

    .styled-button:hover {
        background-color: #FF983D;
    }

    .styled-account {
        position: absolute;
        width: 300px;
        height: 60px;
        left: 540px;
        top: 0px;
        font-family: 'Inter';
        font-style: normal;
        font-weight: 800;
        font-size: 25px;
        line-height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        text-transform: uppercase;
        color: #FFFFFF;
        background-color: #292D3D;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        border-radius: 0px 0px 30px 30px;
        border: none;
        cursor: pointer;
        font-size: large;
    }

    .btn-succes {
        background-color: #FF7B1C;
        color: white;
    }

    .btn-succes:hover {
        background-color: #FF7B1C;
    }

    .btn-succes:active {
        background-color: orange;
    }
</style>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<button class="styled-account" data-toggle="modal" data-target="#example">Add Advanced User</button>
<button class="styled-button" data-toggle="modal" data-target="#exampleModal">Add Advanced Users File</button>

<div class="styled-table">
    <table id="datatable" class="table table-hover table-sm table-bordered p-0" data-page-length="50" style="text-align: center">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Password</th>
                <th>Processes</th>
            </tr>
        </thead>
        <tbody>
        @foreach($usersData as $key => $all)
                <tr>
                <td>{{ $key + 1 }}</td>
                    <td><a href="/assignedService/showAll/{{$all['id']}}">{{ $all['fullName'] }}</a></td>
                    <td>{{ $all['password'] ?? '******' }}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#Delete_Ro" title="Delete"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Advanced User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('addAdvancedUsersFile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="Name" class="mr-sm-2">File:</label>
                            <input id="file" type="file" name="file" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-succes">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="example" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Advanced User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('createAdvancedUserAccount') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="Name" class="mr-sm-2">fullName:</label>
                            <input id="fullName" type="text" name="fullName" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="Name" class="mr-sm-2">password:</label>
                            <input id="password" type="password" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-succes">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="Delete_Ro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">Are you sure to delete??</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('deleteAllAdvancedUsersAccounts') }}">
                @csrf
                @method('DELETE')
                    <input type="hidden" name="id" id="user_id" class="form-control">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    @toastr_js
    @toastr_render
@endsection
