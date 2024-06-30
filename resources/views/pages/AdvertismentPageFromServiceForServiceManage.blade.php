@extends('layouts.master')

@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
Advertisements
@stop
<!-- breadcrumb -->
@endsection

@section('content')
<style>
    .component-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .component {
        position: relative;
        width: 300px;
        height: auto;
        background-color: #ACA6F2;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
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
        width: 300px;
        height: 60px;
        font-family: 'Inter';
        font-weight: 800;
        font-size: 20px;
        line-height: 60px;
        text-align: center;
        text-transform: uppercase;
        color: #FFFFFF;
        background-color: #FF7B1C;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 30px;
        border: none;
        cursor: pointer;
        margin-top: 20px;
    }

    .heart-icon {
        position: absolute;
        bottom: 10px;
        right: 20px;
        cursor: pointer;
    }

    .heart-icon i {
        font-size: 15px;
        color: white;
        transition: color 0.2s;
    }

    .heart-icon i.red {
        color: red;
    }

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
        left: 50%;
        transform: translateX(-50%);
        top: 1%;
        align-items: center;
    }

    #search-input {
        border-radius: 10px;
        border: 1px solid #ccc;
        width: 400px;
        height: 40px;
    }

    .fa-search {
        color: black;
        position: absolute;
        top: 50%;
        left: 95%;
        transform: translate(-50%, -50%);
        cursor: pointer;
        font-size: 20px;
    }

    .delete-container {
        position: absolute;
        top: 1%;
        left: 2%;
    }

    #delete-all-icon {
        font-size: 25px;
        cursor: pointer;
        color: red;
        top: 1px;
        transform: translate(-50%, -50%);
    }

    #delete-all-icon:hover {
        color: darkred;
    }
</style>




<button class="styled-button" data-toggle="modal" data-target="#exampleModal">Add Advertisement</button>

<div class="component-container" id="serviceRecords">
    @foreach($allRecords as $record)
    <div class="component">
        <div class="component-title">Advertisement Details</div>
        <div class="component-item">title: {{ $record['title'] }}</div>
        <div class="component-item"> Description: {{ $record['description'] }}</div>
        <div class="component-item">file: {{ $record['file'] }}</div>
       
    </div>
    @endforeach
</div>

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
                <form id="addServiceForm" action="{{ route('addAnnouncement') }}"method="POST" enctype="multipart/form-data">
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
@endsection

@section('js')
@toastr_js
@toastr_render
@endsection
