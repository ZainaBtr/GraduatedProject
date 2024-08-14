@extends('layouts.master')
@section('page-header')
@section('PageTitle')
    addS
@stop
@endsection
@section('content')
    <style>
        body {
            overflow: hidden;  
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding-top: 100px; /* تعديل لزيادة المسافة من الأعلى */
        }

        .row {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .box {
            padding: 20px; /* زيادة الحشوة الداخلية لزيادة حجم المستطيل */
            margin: 5px;
            width: 250px; /* زيادة العرض */
            height: 90px; /* زيادة الطول */
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px; /* تكبير حجم الخط */
            color: white; /* تغيير لون النص إلى الأبيض */
            border-radius: 10px; /* جعل الحواف دائرية قليلاً */
        }

        .blue {
            background-color: #FF8B3A; /* تغيير لون الخلفية إلى الأزرق */
        }

        .red {
            background-color: #BFB9FD; /* تغيير لون الخلفية إلى الأحمر */
        }

        .green {
            background-color: #77B8A1; /* تغيير لون الخلفية إلى الأخضر */
        }

        .orange {
            background-color: #292d3d; /* تغيير لون الخلفية إلى البرتقالي */
        }

        .center-title {
            position: absolute;
            top: 10%; /* نقل العنوان إلى الأسفل قليلاً */
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: black;
            font-size: 50px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="center-title">STATISTICS</div>
    <div class="container">
        <div class="row">
            <div id="advanced-users" class="box blue">Advanced Users</div>
            <div id="normal-users" class="box blue">Normal Users</div>
            <div id="service-managers" class="box blue">Services Managers</div>
            <div id="total-users" class="box blue">Total Users</div>
        </div>
        <div class="row">
            <div id="open-services" class="box red">Open Services</div>
            <div id="close-services" class="box red">Close Services</div>
            <div id="total-services" class="box red">Total Services</div>
        </div>
        <div class="row">
            <div id="open-sessions" class="box green">Open Sessions</div>
            <div id="open-private-sessions" class="box green">Open Private Sessions</div>
            <div id="open-public-sessions" class="box green">Open Public Sessions</div>
            <div id="total-sessions" class="box green">Total Sessions</div>
        </div>
        <div class="row">
            <div id="total-announcements" class="box orange">Total Announcements</div>
            <div id="total-groups" class="box orange">Total Groups</div>
        </div>
    </div>

    <script>
        // دالة لجلب البيانات من API ووضعها في العنصر المحدد
        function fetchData(url, elementId) {
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    document.getElementById(elementId).innerText += `: ${data}`;
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // جلب البيانات ووضعها في العناصر المناسبة
        fetchData('/statistic/advancedUsersCount', 'advanced-users');
        fetchData('/statistic/normalUsersCount', 'normal-users');
        fetchData('/statistic/serviceManagersCount', 'service-managers');
        fetchData('/statistic/totalUsersCount', 'total-users');
        fetchData('/statistic/announcementsCount', 'total-announcements');
        fetchData('/statistic/openServicesCount', 'open-services');
        fetchData('/statistic/closeServicesCount', 'close-services');
        fetchData('/statistic/totalServicesCount', 'total-services');
        fetchData('/statistic/openSessionsCount', 'open-sessions');
        fetchData('/statistic/openPrivateSessionsCount', 'open-private-sessions');
        fetchData('/statistic/openPublicSessionsCount', 'open-public-sessions');
        fetchData('/statistic/totalSessionsCount', 'total-sessions');
        fetchData('/statistic/groupsCount', 'total-groups');
    </script>

@endsection
@section('js')
    @toastr_js
    @toastr_render
@endsection
