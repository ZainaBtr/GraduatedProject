@extends('layouts.master')
@section('page-header')
@section('PageTitle')
    Normal
@stop
@endsection
@section('content')

<style>
  .styled-table {
    width: 90%; 
    text-align: center;
    margin-top: 5%;
    margin-left: 5%; 
    vertical-align: middle;
}

.styled-table th,
.styled-table td {
    border: none; /* حذف الحدود العمودية للخلايا */
    padding: 10px;
    text-align: center;
    width: auto; /* إعادة تعيين عرض الخلية إلى تحديد التلقائي */
}
.styled-table tr th {
    border-right-color: transparent; 
}


.styled-table th {
    background-color: #292D3D;
    color: #FFFFFF;
    text-align: center;
    padding-left: 20px;
    vertical-align: middle;  
}

.styled-table tr th,
.styled-table tr td {
  border-right-color: white;
  text-align: center;
}
.child-column {
            color: transparent;
            text-align: center;
            margin-left: 10px;
        }
        .vertical-align-top {
            vertical-align: top;
        }
  .group-20 {
    position: absolute;
    width: 369px;
    height: 81px;
    left: 1254px;
    top: 0px;
  }

  .rectangle-21 {
    position: absolute;
    width: 369px;
    height: 81px;
    left: 14px;
    top: 20px;
    background: #FF7B1C;
    box-shadow: 0px 0px 50px rgba(0, 0, 0, 0.5);
    border-radius: 0px 0px 30px 30px;
  }
  .add-service-manager {
    position: absolute;
    width: 309.35px;
    height: 34.71px;
    left:20px;
    top: 20px;
    font-family: 'Inter';
    font-style: normal;
    font-weight: 800;
    font-size: 25px;
    line-height: 30px;
    display: flex;
    align-items: center;
    text-align: center;
    text-transform: uppercase;
    color: #FFFFFF;
    box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.5);
  }
  .styled-button {
    position: absolute;
    width:400px;
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
    font-size:25px;
  }

  .styled-button:hover {
    background-color: #FF983D;
  }
  .styled-table tr th {
    border-right-color: transparent;
  }
  .styled-account:hover {
    background-color: #39465E; 
  }
  .child-column {
    color: transparent;
  }
  .btn-succes {
  background-color: #FF7B1C; 
  color:white;
}

.btn-succes:hover {
  background-color: #FF7B1C; 
}

.btn-succes:active {
  background-color: orange; }

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
    text-align:center;
    text-transform: uppercase;
    color: #FFFFFF;
    background-color: #292D3D; 
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    border-radius: 0px 0px 30px 30px;
    border: none;
    cursor: pointer;
    font-size:50px;
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

<button class="styled-button" data-toggle="modal" data-target="#exampleModal">Add Normal Users File</button>
<br><br>
<div class="styled-table">
    <table id="datatable" class="table table-hover table-sm table-bordered p-0" data-page-length="50" style="text-align: center">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Examination Number</th>
                <th>Year</th>
                <th>Specialization</th>
                <th>Study Situation</th>
                <th>password</th>
                <th>Processes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usersData as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user['fullName'] }}</td>
                <td>{{ $user['examinationNumber'] }}</td>
                <td>{{ $user['serviceYear'] }}</td>
                <td>{{ $user['serviceSpecialization'] }}</td>
                <td>{{ $user['studySituation'] }}</td>
                @if(isset($user['password']))
                <td>{{ $user['password'] }}</td>
                @endif
                <td>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#Delete_Ro" title="Delete">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Normal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('addNormalUsersFile') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col">
              <label for="file" class="mr-sm-2">File:</label>
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
                <form method="POST" action="{{ route('deleteAllNormalUsersAccounts') }}">
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
