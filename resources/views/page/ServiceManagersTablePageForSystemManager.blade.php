<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
    vertical-align: middle;}
.styled-table th,
.styled-table td {
    border: none; 
    padding: 10px;
    text-align: center;
    width: auto; 
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
    font-size: 30px;
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
  background-color: orange; 
}

.styled-account {
    position: absolute;
    width: 50px;
    height: 60px;
    margin-left: 1200px;
    margin-top:40%;
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
    font-size:large;
  }
</style>


         
    <button class="styled-button" data-toggle="modal" data-target="#exampleModal">Add Role</button>

    <button type="button" class="styled-account" data-toggle="modal" data-target="#exampleMod" title="DeleteAll">
                                    <i class="fa fa-trash"></i>
                                        </button>
            <div class="styled-table">
                <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                       data-page-length="50"
                       style="text-align: center">

<thead>
                            <tr>
                                <th>#</th>
                                 <th>fullName</th>
                                 <th>position</th>
                                 <th>password</th>
                                <th>Processes</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; ?>

                            @foreach($result as $users)

                               <tr>
                                   <?php $i++; ?>
                                   <td>{{ $i }}</td>
                                   <td>{{ $users->fullName }}</td>
                                   <td>{{ $users->password }}</td>

                                    <td>

                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModa" title="Delete">
                                    <i class="fa fa-trash"></i>
                                        </button>

                                    </td>
</tr>

                                <!-- delete_modal 1 -->

                                <div class="modal fade" id="exampleModa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                       <div class="modal-dialog" role="document">
                                             <div class="modal-content">
                                               <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">  Are you sure you want to delete this item?</h5>
                                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                             </button>
                                               </div>
                                               <div class="modal-body">     
                                             <form action="{{ route('deleteServiceManagerAccount', ['serviceManager' => $user->id]) }}" method="post">
                                               @csrf
                                          @method('DELETE')
                                       <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                              <button type="submit" class="btn btn-danger">yes</button>
                                              </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                              @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>

       
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">add Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">        
      <form action="{{ route('createServiceManagerAccount') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col">
            <label for="Name" class="mr-sm-2">fullName:</label>
            <input id="fullName" type="text" name="fullName" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="Name" class="mr-sm-2">position:</label>
            <input id="position" type="text" name="position" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="Name" class="mr-sm-2">password:</label>
            <input id="password" type="text" name="password" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip" class="form-control">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">consol</button>
        <button type="submit" class="btn btn-succes">save</button>
    </div>
</form>

    </div>
  </div>
</div>

</body>
</html>