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
        font-size: 15px; /* Ø­Ø¬Ù… Ø§Ù„Ø£ÙŠÙ‚ÙˆÙ†Ø© */
        color: white; /* Ø§Ù„Ù„ÙˆÙ† Ø§Ù„Ø§ÙØªØ±Ø§Ø¶ÙŠ */
        transition: color 0.2s; /* ØªØ£Ø«ÙŠØ± Ø§Ù„Ø§Ù†ØªÙ‚Ø§Ù„ Ø¹Ù†Ø¯ ØªØºÙŠÙŠØ± Ø§Ù„Ù„ÙˆÙ† */
    }

    .heart-icon i.black {
        color: black; /* Ø§Ù„Ù„ÙˆÙ† Ø¹Ù†Ø¯ Ø¥Ø²Ø§Ù„Ø© Ø§Ù„Ø¥Ø¹Ø¬Ø§Ø¨ */
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
        border-radius: 10px; /* Ø²ÙŠØ§Ø¯Ø© Ù†ØµÙ Ù‚Ø·Ø± Ø§Ù„Ø¨ÙˆØ±Ø¯Ø± Ù„ØªØ¨Ø§ÙŠÙ† Ø§Ù„Ø´ÙƒÙ„ */
        border: 1px solid #ccc; /* ØªØºÙŠÙŠØ± Ø¹Ø±Ø¶ Ø§Ù„Ø¨ÙˆØ±Ø¯Ø± */
        width: 400px;
        height: 40px;
    }

    .fa-search {
        color: black;
    }

    .fa-search {
        position: absolute; /* Ø¬Ø¹Ù„ Ø§Ù„Ø£ÙŠÙ‚ÙˆÙ†Ø© Ù…ØªØ­ÙƒÙ…Ø© ÙÙŠ Ø§Ù„Ù…ÙˆÙ‚Ø¹ Ø¯Ø§Ø®Ù„ Ø§Ù„Ø²Ø± */
        top: 50%;
        left: 95%;
        transform: translate(-50%, -50%);
        cursor: pointer;
    }

    /* ØªØ­Ø¯ÙŠØ¯ Ø­Ø¬Ù… Ø§Ù„Ø£ÙŠÙ‚ÙˆÙ†Ø© */
    .fa-search {
        font-size: 20px;
    }
    .center-title {
        position:absolute;
        text-align: center;
        color: black;
        font-size: 50px;
        font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        margin-left: 33%;

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
<div class="center-title">Favorite service</div>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
        $.ajax({
            method: "GET",
            url: "http://127.0.0.1:8000/service/showServiceYearAndSpecForDynamicDropDown",
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
                        <div class="component">
                            <div class="component-title">Service Details</div>
                            <div class="component-item">Service Name: ${newRecord.serviceName}</div>
                            <div class="component-item">Service Type: ${newRecord.serviceType}</div>
                            <div class="component-item">Service Description: ${newRecord.serviceDescription}</div>
                            <div class="component-item">Minimum Number Of Group: ${newRecord.minimumNumberOfGroupMembers}</div>
                            <div class="component-item">Maximum Number Of Group: ${newRecord.maximumNumberOfGroupMembers}</div>
                        </div>
                    `;

                    $('#serviceRecords').append(newComponent);
                    $('#addServiceForm')[0].reset();
                    $('#exampleModal').modal('hide');
                    $('.styled-button').after(newComponent);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });

    function toggleInterest(serviceId, element) {
        var icon = $(element).find('i');

        if (icon.hasClass('red')) {
            // Remove interest
            $.ajax({
                method: 'DELETE',
                url: 'interestedService/unInterestInService/' + serviceId,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    icon.removeClass('red').addClass('black');
                    console.log('Service removed successfully');
                },
                error: function(xhr, status, error) {
                    console.error('Error removing service:', error);
                }
            });
        } else {
            // Add interest
            $.ajax({
                method: 'POST',
                url: '/interestedService/interestInService/' + serviceId,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    icon.removeClass('black').addClass('red');
                    console.log('Interest recorded successfully');
                },
                error: function(xhr, status, error) {
                    console.error('Error recording interest:', error);
                }
            });
        }
    }
</script>

@endsection

@section('js')
@toastr_js
@toastr_render
@endsection
