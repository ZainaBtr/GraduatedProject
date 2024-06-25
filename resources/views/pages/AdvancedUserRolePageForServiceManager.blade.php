@extends('layouts.master')

@section('page-header')
    @section('PageTitle')
        Meal
    @stop
@endsection

@section('content')
    <style>
        .styled-table {
            width: 80%;
            text-align: center;
            border: 1px solid #ddd;
            margin-top: 5%;
            margin-left: 10%;
            vertical-align: middle;
        }

        .styled-table th, .styled-table td {
            border: none;
            padding: 10px;
            text-align: center;
        }

        .styled-table tr th {
            background-color: #292d3d;
            color: #ffffff;
        }

        .styled-button {
            position: absolute;
            width: 400px;
            height: 60px;
            left: 800px;
            top: 0;
            font-family: 'Inter', sans-serif;
            font-weight: 800;
            font-size: 25px;
            color: #ffffff;
            background-color: #ff7b1c;
            border-radius: 0 0 30px 30px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .styled-button:hover {
            background-color: #ff983d;
        }
    </style>

    <table class="styled-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Role Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allRecords as $index => $allRecord)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $allRecord->role->roleName }}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#Delete{{ $allRecord->id }}">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>

            <!-- Modal for Delete -->
            <div class="modal fade" id="Delete{{ $allRecord->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this record?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <form action="{{ route('deleteAssignedRole', $allRecord->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Yes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal for Delete -->
            @endforeach
        </tbody>
    </table>

    <!-- Button to Add Role -->
    <button class="styled-button" data-toggle="modal" data-target="#exampleModal">Add Role</button>

    <!-- Modal for Add Role -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('assignRole', $assignedService->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="roleName">Role Name:</label>
                            <select id="roleName" name="id" class="form-control">
                                <option value="" disabled selected>Choose Role</option>
                                <!-- Options will be populated dynamically using JavaScript -->
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                method: "GET",
                url: "{{ route('showRoleForDynamicDropDown') }}",
                dataType: "json",
                success: function(data) {
                    $.each(data, function(index, role) {
                        $('#roleName').append(`<option value="${role.id}">${role.roleName}</option>`);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                    console.error(status);
                    console.error(error);
                }
            });
        });
    </script>
@endsection

@section('js')
    @toastr_js
    @toastr_render
@endsection
