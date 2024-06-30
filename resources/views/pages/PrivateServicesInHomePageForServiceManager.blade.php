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
    .component-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center; /* Optional: Center the items horizontally */
    }

    .component {
        position: relative;
        width: 300px;
        height: auto;
        margin: 20px;
        background-color: #64A78F;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 80px;
        margin-left: 30px;
    }

    .component-title {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .component-item {
        width: 100%;
        margin: 5px 0;
    }

    .styled-button {
        position: absolute;
        width: 300px;
        height: 60px;
        left: 85%;
        transform: translateX(-50%);
        top: 2px;
        font-family: 'Inter';
        font-weight: 800;
        font-size: 20px;
        line-height: 60px;
        text-align: center;
        text-transform: uppercase;
        color: #FFFFFF;
        background-color: #FF7B1C;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 0px 0px 30px 30px;
        border: none;
        cursor: pointer;
    }

    .heart-icon {
        position: absolute;
        bottom: 10px;
        right: 20px;
        cursor: pointer;
    }

    .heart-icon i {
        font-size: 24px; /* حجم الأيقونة */
        color: black; /* اللون الافتراضي */
        transition: color 0.2s; /* تأثير الانتقال عند تغيير اللون */
    }

    .heart-icon i.red {
        color: red; /* اللون عند الإعجاب */
    }
    /* Modal Style */
    .modal-dialog {
        max-width: 800px;
    }

    .modal-content {
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    }

    .modal-header {
        background-color: #77B8A1;
        color: white;
        border-radius: 10px 10px 0 0;
    }

    .modal-title {
        font-weight: bold;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        border-top: none;
    }
    .search-container {
        position: absolute;
        left: 20%;
        top: 3%;
        transform: translate(-50%, -50%);
        align-items: center;
    }

    #search-input {
        border-radius: 10px; /* زيادة نصف قطر البوردر لتباين الشكل */
        border: 1px solid #ccc; /* تغيير عرض البوردر */
        width: 400px;
        height: 40px;
    }

    .fa-search {
        color: black;
    }

    .fa-search {
        position: absolute; /* جعل الأيقونة متحكمة في الموقع داخل الزر */
        top: 50%;
        left: 95%;
        transform: translate(-50%, -50%);
        cursor: pointer;
    }

    /* تحديد حجم الأيقونة */
    .fa-search {
        font-size: 20px;
    }
</style>

<button class="styled-button" data-toggle="modal" data-target="#exampleModal">ADD services</button>

<!-- Search form -->
<form id="searchForm" action="{{ route('searchForServiceByServiceName') }}" method="GET">
    <div class="search-container">
        <input type="text" name="serviceName" id="search-input" placeholder="Search" class="form-control">
        <i class="fa fa-search" onclick="document.getElementById('searchForm').submit();"></i>
    </div>
</form>

<div class="component-container" id="serviceRecords">
    @foreach($allRecords as $record)
    <div class="component">
        <div class="component-title">Service Details</div>
        <div class="component-item">Service Name: {{ $record['serviceName'] }}</div>
        <div class="component-item">Service Type: {{ $record['serviceType'] }}</div>
        <div class="component-item">Service Description: {{ $record['serviceDescription'] }}</div>
        <div class="component-item">Service Year: {{ $record['serviceYearName'] }}</div>
        <div class="component-item">Specialization: {{ $record['serviceSpecializationName'] }}</div>
        <div class="component-item">Minimum Group Members: {{ $record['minimumNumberOfGroupMembers'] }}</div>
        <div class="component-item">Maximum Group Members: {{ $record['maximumNumberOfGroupMembers'] }}</div>
        <div class="component-item">Status: {{ $record['statusName'] }}</div>
        <div class="component-item">
            <strong>Advanced Users with Roles:</strong>
            @foreach($record['advancedUsersWithRoles'] as $user)
                <div>{{ $user['fullName'] }} - Roles: {{ implode(', ', $user['roles']->toArray()) }}</div>
                @endforeach
        </div>
    </div>
    @endforeach
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
          
            <form id="addServiceForm" action="{{  route('addService', ['parentService' => $parentService->id]) }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="serviceName">Service Name:</label>
                        <input id="serviceName" type="text" name="serviceName" class="form-control">
                    </div>
                
                    <input type="hidden" id="parentServiceID" name="parentServiceID" value="{{ $parentService->id }}">

                    <div class="form-group">
                        <label for="serviceType">Service Type:</label>
                        <select id="serviceType" name="serviceType" class="form-control">
                            <option value="lectures">lectures</option>
                            <option value="exams">exams</option>
                            <option value="projects interviews">projectsInterviews</option>
                            <option value="advanced users interviews">advancedUsersInterviews</option>
                            <option value="activities">activities</option>
                            <option value="others">others</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="serviceDescription">service Description</label>
                        <input id="serviceDescription" type="text" name="serviceDescription" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="serviceYearAndSpecializationID">Service Year & Specialization:</label>
                        <select id="serviceYearAndSpecializationID" name="serviceYearAndSpecializationID" class="form-control">
                            <option value="" disabled selected>Select Year & Specialization</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="minimumNumberOfGroupMembers">Minimum Number Of Group:</label>
                        <input id="minimumNumberOfGroupMembers" type="number" name="minimumNumberOfGroupMembers" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="maximumNumberOfGroupMembers">Maximum Number Of Group:</label>
                        <input id="maximumNumberOfGroupMembers" type="number" name="maximumNumberOfGroupMembers" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <input type="hidden" name="serviceManagerID">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
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
            method: "GET",
            url: "http://127.0.0.1:8000/api/service/showServiceYearAndSpecForDynamicDropDown",
            dataType: "json",
            success: function(data, status) {
                $.each(data, function(k, v) {
                    $('#serviceYearAndSpecializationID').append(`<option value="${v.id}">${v.serviceSpecializationName} - ${v.serviceYear}</option>`);
                });
            },
            error: function(x, y, z) {
                console.log(x);
                console.log(y);
                console.log(z);
            }
        });
    });

    $(document).on('click', '.heart-icon i', function() {
    var serviceId = $(this).closest('.heart-icon').data('service-id');
    var currentColor = $(this).css('color');

    if (currentColor === 'rgb(255, 0, 0)') { // Red color
        unInterestInService(interestedService);
    } else {
        interestInService(serviceId);
    }
});

function interestInService(serviceId) {
    $.ajax({
        method: 'POST',
        url: '/interestedService/interestInService/' + serviceId,
        data: {
            _token: '{{ csrf_token() }}'
        },
        dataType: 'json',
        success: function(response) {
            console.log('Interest recorded successfully');
            $('div[data-service-id="' + serviceId + '"] i').css('color', 'red');
        },
        error: function(xhr, status, error) {
            console.error('Error recording interest:', error);
        }
    });
}

function unInterestInService(interestedService) {
    $.ajax({
        method: 'DELETE',
        url: '/interestedService/unInterestInService/' +interestedService ,
        data: {
            _token: '{{ csrf_token() }}'
        },
        dataType: 'json',
        success: function(response) {
            console.log('Interest removed successfully');
            $('div[data-service-id="' + interestedService + '"] i').css('color', 'black');
        },
        error: function(xhr, status, error) {
            console.error('Error removing interest:', error);
        }
    });
}
function setParentServiceID(parentServiceID) {
    document.getElementById('parentServiceID').value = parentServiceID;
}

</script>


@endsection

@section('js')
@toastr_js
@toastr_render
@endsection
