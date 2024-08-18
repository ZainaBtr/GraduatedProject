@extends('layouts.master')

@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
Advertisements
@stop
<!-- breadcrumb -->
@endsection

@section('content')
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
    /* تحسين نمط عرض الإعلانات */
    .component-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        max-width: 100%;
    }

    .component {
        position: relative;
        width: 300px;
        background-color: #ACA6F2;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 50px;
    }

    /* تحسين نمط الأزرار */
    .styled-button, .styled-account {
        position: absolute;
        font-family: 'Inter';
        font-weight: 800;
        font-size: 25px;
        text-align: center;
        color: #FFFFFF;
        border-radius: 0px 0px 30px 30px;
        border: none;
        cursor: pointer;
        font-size: large;
    }

    .styled-button {
        width: 400px;
        height: 60px;
        left: 800px;
        top: 1px;
        background-color: #FF7B1C;
    }

    .styled-button:hover {
        background-color: #FF983D;
    }

    .styled-account {
        width: 300px;
        height: 60px;
        left: 540px;
        background-color: #292D3D;
    }

    #toast-container > div {
        background-color: #77B8A1; /* لون كحلي */
        color: white; /* لون النص */
    }

    .download-icon i {
        font-size: 20px;
        color: white;
        cursor: pointer;
        transition: color 0.2s;
    }

    .download-icon i:hover {
        color: #FF7B1C;
    }

    .save-icon {
        position: absolute;
        bottom: 10px;
        left: 10px;
    }

    .save-icon i {
        font-size: 20px;
        color: white;
        transition: color 0.2s;
        cursor: pointer;
    }

    .save-icon i.saved {
        color: black;
    }
</style>

<button class="styled-button" data-toggle="modal" data-target="#exampleModal">Add Advertisement</button>

<div class="component-container" id="serviceRecords">
    @foreach($allRecords as $record)
        <div class="component">
            <div class="component-title">Advertisement Details</div>
            <div class="component-item">Title: {{ $record['title'] }}</div>
            <div class="component-item">Description: {{ $record['description'] }}</div>
            <div class="component-item">
                File:
                @if($record['file'])
                    @foreach($record['file'] as $file)
                        <a href="{{ route('downloadFile', $file['id']) }}" class="download-icon">
                            <i class="fa fa-download"></i>
                            {{ $file['fileName'] }}
                        </a><br>
                    @endforeach
                    <div class="save-icon" 
                         data-service-id="{{ $record['id'] }}" 
                         data-saved-service-id="{{ isset($record['savedService']) ? $record['savedService']['id'] : '' }}">
                        <i class="fa fa-bookmark {{ $record['isSaved'] ? 'saved' : '' }}"></i>
                    </div>
                @else
                    No file
                @endif
            </div>
        </div>
    @endforeach
</div>

<!-- Modal لإضافة إعلان -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Advertisement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addServiceForm" action="{{ route('addAnnouncement') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input id="title" type="text" name="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input id="description" type="text" name="description" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="file">File:</label>
                        <input id="file" type="file" name="file" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- تأكد من تحميل jQuery أولاً -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function() {
        @if(session('notificationData'))
            var notificationData = {!! json_encode(session('notificationData')) !!};

            toastr.success(
                "serviceName: " + notificationData.serviceName + "<br>title: " + notificationData.title,
                "New Announcement",
                {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: "10000"
                }
            );
        @endif
    });

    $('.save-icon').click(function() {
        var savedServiceId = $(this).data('saved-service-id');
        var icon = $(this).find('i');

        if (icon.hasClass('saved')) {
            unSaveService(savedServiceId, icon);
        } else {
            var serviceId = $(this).data('service-id');
            saveService(serviceId, icon);
        }
    });

    function saveService(serviceId, icon) {
        $.ajax({
            method: 'POST',
            url: '/savedAnnouncement/save/' + serviceId,
            data: {
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                console.log('Service saved successfully');
                icon.addClass('saved');
                icon.closest('.save-icon').data('saved-service-id', response.id);
            },
            error: function(xhr, status, error) {
                console.error('Error saving service:', error);
            }
        });
    }

    function unSaveService(savedServiceId, icon) {
        $.ajax({
            method: 'DELETE',
            url: '/savedAnnouncement/unSave/' + savedServiceId,
            data: {
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                console.log('Service unsaved successfully');
                icon.removeClass('saved');
                icon.closest('.save-icon').removeData('saved-service-id');
            },
            error: function(xhr, status, error) {
                console.error('Error unsaving service:', error);
            }
        });
    }
</script>

@endsection
@section('js')
    @toastr_js
    @toastr_render
@endsection
