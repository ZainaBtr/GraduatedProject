@extends('layouts.master')

@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
Meal
@stop
<!-- breadcrumb -->
@endsection

@section('content')
<style>
    /* Component 8 */
    #component8 {
        position: absolute;
        width: 300px;
        height: 400px;
        left: 50px;
        top: 120px;
        background-color: #FFFFFF;
    }

    /* Component 17 */
    #component17 {
        position: absolute;
        left: 0%;
        right: 0%;
        top: 0%;
        bottom: 0%;
        background-color: #77B8A1;
        border-radius: 29px;
    }

    /* Group 25 */
    #group25 {
        position: absolute;
        left: 0%;
        right: 0%;
        top: 0%;
        bottom: 0%;
    }

    .styled-button {
        position: absolute;
        width: 300px;
        height: 60px;
        left: 900px;
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

    .btn-succes {
        background-color: #FF7B1C;
        color: white;
    }

    /* لتحديد أيقونة البحث */
    .search-container {
        position: absolute;
        left: 52%;
        top: 14%;
        transform: translate(-50%, -50%);
        align-items: center;
    }

    #search-input {
        border-radius: 10px;
        /* زيادة نصف قطر البوردر لتباين الشكل */
        border: 1px solid #ccc;
        /* تغيير عرض البوردر */
        width: 600px;
        height: 40px;
    }

    .fa-search {
        color: black;
    }

    .fa-search {
        position: absolute;
        /* جعل الأيقونة متحكمة في الموقع داخل الزر */
        top: 50%;
        left: 95%;
        transform: translate(-50%, -50%);
        cursor: pointer;
    }

    /* تحديد حجم الأيقونة */
    .fa-search {
        font-size: 20px;
    }

    .col {
        margin-top: 30px;
    }

    /* تحديد موقع حقول الإدخال بعد الضغط على زر "Save" */
    .modal-content .modal-body .row:last-child .col input {
        margin-top: 10px;
    }
</style>

<button class="styled-button" data-toggle="modal" data-target="#exampleModal"> ADD services </button>

<div id="component8">
    <div id="component17"></div>
    <div id="group25"></div>
    <strong style="position: absolute; top: 10%; left: 22%; transform: translate(-50%, -50%);">Service Name:</strong>
    <strong style="position: absolute; top: 20%; left: 21%; transform: translate(-50%, -50%);">Service Type:</strong>
    <strong style="position: absolute; top: 30%; left: 27%; transform: translate(-50%, -50%);">Service Description:</strong>
    <strong style="position: absolute; top: 45%; left: 20%; transform: translate(-50%, -50%);">Service Year :</strong>
    <strong style="position: absolute; top: 55%; left: 30%; transform: translate(-50%, -50%);">Service Specialization:</strong>
    <strong style="position: absolute; top: 70%; left: 35%; transform: translate(-50%, -50%);">Minimum Number Of Group:</strong>
    <strong style="position: absolute; top: 80%; left: 35%; transform: translate(-50%, -50%);">Maximum Number Of Group</strong>
    <strong style="position: absolute; top: 90%; left: 12%; transform: translate(-50%, -50%);">Status:</strong>
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Services</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col">
                            <label for="serviceName" class="mr-sm-2">Service Name:</label>
                            <input id="serviceName" type="text" name="serviceName" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="serviceType" class="mr-sm-2">Service Type:</label>
                            <select id="serviceType" name="serviceType" class="form-control">
                                <option value="lectures">Lectures</option>
                                <option value="exams">Exams</option>
                                <option value="projects interviews">Projects Interviews</option>
                                <option value="advanced users interviews">Advanced Users Interviews</option>
                                <option value="activities">Activities</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="serviceYear" class="mr-sm-2">Service Year & specialization:</label>
                            <select id="serviceYear" name="serviceYear" class="form-control">
                                <option value="" disabled selected>Select Year & specialization </option>
                            </select>
                        </div>
                        <!-- <div class="col">
                            <label for="serviceSpecialization" class="mr-sm-2">Service Specialization:</label>
                            <select id="serviceSpecializationName" name="serviceSpecializationName" class="form-control">
                                <option value="" disabled selected>Select Specialization</option>
                            </select>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="minimumNumberOfGroup" class="mr-sm-2">Minimum Number Of Group:</label>
                            <input id="minimumNumberOfGroup" type="number" name="minimumNumberOfGroup" class="form-control">
                        </div>
                        <div class="col">
                            <label for="maximumNumberOfGroup" class="mr-sm-2">Maximum Number Of Group:</label>
                            <input id="maximumNumberOfGroup" type="number" name="maximumNumberOfGroup" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="status" class="mr-sm-2">Status:</label>
                            <select id="status" name="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
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

<div class="search-container">
    <input type="text" id="search-input" placeholder="Search...">
    <i class="fa fa-search"></i>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>



    $(document).ready(function() {

 

        $.ajax({
            method: "Get",
            url: "http://127.0.0.1:8000/api/service/showServiceYearAndSpecForDynamicDropDown",
            dataType: "json",
            success: function(data, status) {
                // console.log(status);
                // console.log(data);
                
                // $('select[id="serviceYear"]').empty();
                $.each(data, function(k, v) {
                    $('select[id="serviceYear"]').append(`<option value="${v.id}">serviceSpecializationName is : ${v.serviceSpecializationName} and serviceYear is : ${v.serviceYear}</option>`);
                    console.log(`serviceSpecializationName is : ${v.serviceSpecializationName} and serviceYear is : ${v.serviceYear}`);
                })
            },
            error: function(x, y, z) {
                console.log(x)
                console.log(y)
                console.log(z)
            }
        });


      
    });
</script>


@endsection
@section('js')
@toastr_js
@toastr_render
@endsection