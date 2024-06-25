<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Styled Table</title>
    <style>
        body {
            overflow: hidden;
        }
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
            font-size: 20px;
        }
        .styled-button:hover {
            background-color: #FF983D;
        }
        .styled-account {
            position: absolute;
            width: 50px;
            height: 60px;
            margin-left: 1200px;
            margin-top: 40%;
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
    .styledd-account {
    position: absolute;
    width: 250px;
    height: 60px;
    left: 590px;
    top: 0px;
    font-family: 'Inter';
    font-style: normal;
    font-weight: 800;
    font-size: 25px;
    line-height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align:center;
    text-transform: uppercase;
    color: #FFFFFF;
    background-color: #292D3D; /* Changed background color */
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    border-radius: 0px 0px 30px 30px;
    border: none;
    cursor: pointer;
    font-size:large;
  }
    </style>
</head>
<body>
<a href="{{ route('showSystemManagerProfile') }}" class="styledd-account">My Profile</a>
<button class="styled-button" data-toggle="modal" data-target="#exampleModal">Add Service Manager</button>

<button type="button" class="styled-account" data-toggle="modal" data-target="#exampleMod" title="DeleteAll">
    <i class="fa fa-trash"></i>
</button>

<div class="styled-table">
    <table id="datatable" class="table table-hover table-sm table-bordered p-0" data-page-length="50" style="text-align: center">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Position</th>
                <th>Processes</th>
            </tr>
        </thead>
        <tbody>
          
                @foreach($usersData as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user['fullName'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ $user['password'] }}</td>
                        <td>{{ $user['position'] }}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $user['id'] }}" title="Delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- delete_modal -->
                    <div class="modal fade" id="deleteModal{{ $user['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this item?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('deleteAccount', ['user' => $user['id']]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                            <button type="submit" class="btn btn-danger">Yes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
          
        </tbody>
    </table>
</div>

<!-- Add Role Modal -->
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
                <form action="{{ route('createServiceManagerAccount') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="fullName">Full Name:</label>
                        <input id="fullName" type="text" name="fullName" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input id="email" type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input id="password" type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="position">Position:</label>
                        <input id="position" type="text" name="position" class="form-control">
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

</body>
</html>
