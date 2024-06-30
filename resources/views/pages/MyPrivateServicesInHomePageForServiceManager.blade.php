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
        margin-top: 100px;
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

    .action-icons {
        display: flex;
        justify-content: space-around;
        width: 100%;
        margin-top: 10px;
    }

    .icon {
        cursor: pointer;
        font-size: 20px;
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
    .center-title {
        position: absolute;
        text-align: center;
        color: black;
        font-size: 50px;
        font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        margin-left: 38%;
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

</style>
<button class="styled-button" data-toggle="modal" data-target="#exampleModal">ADD services</button>
<div class="center-title">my service</div>
<div class="component-container">
    @foreach($allRecords as $record)
    <div class="component" data-id="{{ $record['id'] }}"
    data-service-name="{{ $record['serviceName'] }}"
    data-service-type="{{ $record['serviceType'] }}"
    data-service-description="{{ $record['serviceDescription'] }}"
    data-min-group-members="{{ $record['minimumNumberOfGroupMembers'] }}"
    data-max-group-members="{{ $record['maximumNumberOfGroupMembers'] }}">
    <div class="component-title">Service Details</div>
    <div class="component-item"><a href="/service/showMyChildFromServiceManager/{{$record['id']}}">Service Name: {{ $record['serviceName'] }}</a></div>
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
    <div class="action-icons">
        <span class="icon update-icon" data-toggle="modal" data-target="#updateModal" data-id="{{ $record['id'] }}">✎</span>
        <span class="icon delete-icon" data-id="{{ $record['id'] }}">🗑️</span>
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
                    <input type="hidden" name="serviceManagerID" >
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateServiceForm" action="{{ route('updateService', ['service' => 0]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="updateServiceName">Service Name:</label>
                        <input id="updateServiceName" type="text" name="serviceName" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="updateServiceType">Service Type:</label>
                        <select id="updateServiceType" name="serviceType" class="form-control">
                            <option value="lectures">lectures</option>
                            <option value="exams">exams</option>
                            <option value="projects interviews">projectsInterviews</option>
                            <option value="advanced users interviews">advancedUsersInterviews</option>
                            <option value="activities">activities</option>
                            <option value="others">others</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="updateServiceDescription">Service Description</label>
                        <input id="updateServiceDescription" type="text" name="serviceDescription" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="updateServiceYearAndSpecializationID">Service Year & Specialization:</label>
                        <select id="updateServiceYearAndSpecializationID" name="serviceYearAndSpecializationID" class="form-control">
                            <option value="" disabled selected>Select Year & Specialization</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="updateMinimumNumberOfGroupMembers">Minimum Number Of Group:</label>
                        <input id="updateMinimumNumberOfGroupMembers" type="number" name="minimumNumberOfGroupMembers" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="updateMaximumNumberOfGroupMembers">Maximum Number Of Group:</label>
                        <input id="updateMaximumNumberOfGroupMembers" type="number" name="maximumNumberOfGroupMembers" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="updateStatus">Status:</label>
                        <select id="updateStatus" name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <input type="hidden" id="updateServiceId" name="serviceId">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        // Fetch dropdown options for add form
        $.ajax({
            method: "GET",
            url: "http://127.0.0.1:8000/service/showServiceYearAndSpecForDynamicDropDown",
            dataType: "json",
            success: function(data) {
                $.each(data, function(k, v) {
                    $('#serviceYearAndSpecializationID, #updateServiceYearAndSpecializationID').append(`<option value="${v.id}">${v.serviceSpecializationName} - ${v.serviceYear}</option>`);
                });
            },
            error: function(x, y, z) {
                console.log(x, y, z);
            }
        });

        // Handle add form submission
        $('#addServiceForm').submit(function(e) {

            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var data = form.serialize();

            $.ajax({
                method: method,
                url: url,
                data: data,
                dataType: "json",
                success: function(response) {
                    var newRecord = response;
                    var newComponent = `
                        <div class="component" data-id="${newRecord.id}"
                            data-service-name="${newRecord.serviceName}"
                            data-service-type="${newRecord.serviceType}"
                            data-service-description="${newRecord.serviceDescription}"
                            data-min-group-members="${newRecord.minimumNumberOfGroupMembers}"
                            data-max-group-members="${newRecord.maximumNumberOfGroupMembers}">
                            <div class="component-title">Service Details</div>
                            <div class="component-item">Service Name: ${newRecord.serviceName}</div>
                            <div class="component-item">Service Type: ${newRecord.serviceType}</div>
                            <div class="component-item">Service Description: ${newRecord.serviceDescription}</div>
                            <div class="component-item">Minimum Number Of Group: ${newRecord.minimumNumberOfGroupMembers}</div>
                            <div class="component-item">Maximum Number Of Group: ${newRecord.maximumNumberOfGroupMembers}</div>
                            <div class="action-icons">
                                <span class="icon update-icon" data-toggle="modal" data-target="#updateModal" data-id="${newRecord.id}">✎</span>
                                <span class="icon delete-icon" data-id="${newRecord.id}">🗑️</span>
                            </div>
                        </div>
                    `;
                    $('.component-container').append(newComponent);
                    form[0].reset();
                    $('#exampleModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        // Handle update icon click
        $(document).on('click', '.update-icon', function() {
            var component = $(this).closest('.component');
            var serviceId = component.data('id');
            var serviceName = component.data('service-name');
            var serviceType = component.data('service-type');
            var serviceDescription = component.data('service-description');
            var minGroupMembers = component.data('min-group-members');
            var maxGroupMembers = component.data('max-group-members');

            $('#updateServiceName').val(serviceName);
            $('#updateServiceType').val(serviceType);
            $('#updateServiceDescription').val(serviceDescription);
            $('#updateMinimumNumberOfGroupMembers').val(minGroupMembers);
            $('#updateMaximumNumberOfGroupMembers').val(maxGroupMembers);
            $('#updateServiceId').val(serviceId);

            $('#updateServiceForm').attr('action', `/service/update/${serviceId}`);
        });

        // Handle delete icon click
        $(document).on('click', '.delete-icon', function() {
            var serviceId = $(this).data('id');
            if (confirm('Are you sure you want to delete this service?')) {
                $.ajax({
                    method: 'DELETE',
                    url: `/service/delete/${serviceId}`,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $(`.component[data-id="${serviceId}"]`).remove();
                        alert(response.message);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
    });
</script>

@endsection

@section('js')
@toastr_js
@toastr_render
@endsection
