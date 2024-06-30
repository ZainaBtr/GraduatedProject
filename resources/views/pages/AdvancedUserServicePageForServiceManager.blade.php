@extends('layouts.master')

@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
        Meal
    @stop
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <style>
        /* أسلوب إعادة تعيين الأنماط */
        /* Styled Table */
        .styled-table {
            width: 80%; /* زيادة عرض الجدول */
            text-align: center;
            border: 1px solid #ddd;
            margin-top: 5%;
            margin-left: 10%;
            vertical-align: middle; /* تحديد هامش لليسار لتوسيع المساحة العرضية */
        }

        .styled-table th,
        .styled-table td {
            border: none; /* حذف الحدود العمودية للخلايا */
            padding: 10px;
            text-align: center;
            width: auto; /* إعادة تعيين عرض الخلية إلى تحديد التلقائي */
        }

        .styled-table tr th {
            border-right-color: transparent; /* حذف الحدود العمودية للعناصر الفردية */
            background-color: #292d3d;
            color: #ffffff;
            text-align: center; /* زيح الكلمات إلى اليسار في عمود "Service Year" */
            padding-left: 20px;
            vertical-align: middle; /* تحديد هامش لليسار داخل الخلية */
        }

        /* تغيير لون خطوط الجدول العمودية */
        .styled-table tr th,
        .styled-table tr td {
            border-right-color: white;
            text-align: center;
        }

        /* New styles for Group 20 */
        /* Group 20 */
        .group-20 {
            position: absolute;
            width: 369px;
            height: 81px;
            left: 1254px;
            top: 0px;
        }

        /* Rectangle 21 */
        .rectangle-21 {
            position: absolute;
            width: 369px;
            height: 81px;
            left: 14px;
            top: 20px;
            background: #ff7b1c;
            box-shadow: 0px 0px 50px rgba(0, 0, 0, 0.5);
            border-radius: 0px 0px 30px 30px;
        }

        /* Add Service Manager */
        .add-service-manager {
            position: absolute;
            width: 309.35px;
            height: 34.71px;
            left: 20px;
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
            color: #ffffff;
            box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.5);
        }

        /* Button style */
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
            color: #ffffff;
            background-color: #ff7b1c;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);
            border-radius: 0px 0px 30px 30px;
            border: none;
            cursor: pointer;
        }

        .styled-button:hover {
            background-color: #ff983d;
        }

        /* تغيير لون الخطوط العمودية للعناصر الفردية */
        .styled-table tr th {
            border-right-color: transparent;
        }

        /* تغيير لون النص في أعمدة الأبناء إلى شفاف */
        .child-column {
            color: transparent;
        }

        .btn-success {
            background-color: #ff7b1c;
            color: white; /* لون الزر البرتقالي */
        }

        .btn-success:hover {
            background-color: #ff7b1c; /* لون الزر البرتقالي عند التحويم */
        }

        .btn-success:active {
            background-color: orange; /* لون الزر البرتقالي عند الضغط */
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
    <button type="button" class="styled-account" data-toggle="modal" data-target="#exampleMod" title="DeleteAll">
                                    <i class="fa fa-trash"></i>
                                        </button>


<table class="styled-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Service Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allRecords as $index => $allRecord)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><a href="/assignedRole/showAll/{{$allRecord->id}}">{{ $allRecord->service->serviceName }}</a></td> <!-- Access the service name through the relationship -->
                <td>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#Delete{{ $allRecord->id }}" title="Delete">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>

            <!-- Modal for Delete -->
            <div class="modal fade" id="Delete{{ $allRecord->id }}" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                Delete
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this record?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <form action="{{ route('deleteAssignedService', $allRecord->id) }}" method="POST">
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

    <!-- Button to Add Service -->
    <button class="styled-button" data-toggle="modal" data-target="#exampleModal">Add Service</button>

    <!-- Modal for Add Service -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('assignService', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="serviceName">Service Name:</label>
                            <select id="serviceName" name="id" class="form-control">
                                <option value="" disabled selected>Choose Service</option>
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

    <div class="modal fade" id="exampleMod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                       <div class="modal-dialog" role="document">
                                             <div class="modal-content">
                                               <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">  Are you sure you want to delete all item?</h5>
                                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                             </button>
                                               </div>
                                               <div class="modal-body">
                                               <form action="{{ route('deleteAllAssignedServices', ['user' => $user->id]) }}" method="post">

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



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                method: "Get",
                url: "http://127.0.0.1:8000/service/showServiceNameForDynamicDropDown",
                dataType: "json",
                success: function(data, status) {
                    $.each(data, function(k, v) {
                        $('select[id="serviceName"]').append(`<option value="${v.id}">    ${v.serviceName}</option>`);
                        console.log(`id : ${v.id} and serviceName is : ${v.serviceName}`);
                    });
                },
                error: function(x, y, z) {
                    console.log(x);
                    console.log(y);
                    console.log(z);
                }
            });
        });
    </script>
@endsection

@section('js')
    @toastr_js
    @toastr_render
@endsection
