<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite Public Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMv7AjlBdsjVr6swPe5tCSZrM53O5nQfNPhqKjp" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
<div class="container">
    <h1>Favorite Public Services</h1>
    <div class="row">
        @foreach($allRecords as $record)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $record['serviceName'] }}</h5>
                        <p class="card-text">
                            Type: {{ $record['serviceType'] }}<br>
                            Description: {{ $record['serviceDescription'] }}<br>
                            Year: {{ $record['serviceYearName'] }}<br>
                            Specialization: {{ $record['serviceSpecializationName'] }}<br>
                            Status: {{ $record['statusName'] }}
                        </p>
                        <button class="btn" id="interest-btn-{{ $record['id'] }}"
                                onclick="toggleInterest({{ $record['id'] }}, {{ $record['isInterested'] ? 1 : 0 }}, '{{ json_encode($record['interestedService']) }}')"
                                data-interested-service='{{ json_encode($record['interestedService']) }}'>
                            {{ $record['isInterested'] ? 'Uninterested' : 'Interested' }}
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($allRecords as $record)
        let serviceId = {{ $record['id'] }};
        let isInterested = localStorage.getItem('service-' + serviceId) === 'true';
        let button = document.getElementById('interest-btn-' + serviceId);
        if (button) {
            updateButtonState(button, isInterested);
        }
        @endforeach
    });

    function toggleInterest(serviceId, isInterested, interestedServiceJson) {
        let interestedService = JSON.parse(interestedServiceJson);

        let url, method;

        if (isInterested) {
            if (interestedService && interestedService.id) {
                url = `/interestedService/unInterestInService/${interestedService.id}`;
                method = 'DELETE';
            } else {
                console.error("Interested Service ID is empty while trying to uninterest.");
                return;
            }
        } else {
            url = `/interestedService/interestInService/${serviceId}`;
            method = 'POST';
        }

        console.log(`URL: ${url}, Method: ${method}`);

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: method === 'POST' ? JSON.stringify({ serviceId: serviceId }) : null
        })
            .then(response => {
                console.log(`Response status: ${response.status}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.message || data.id) {
                    let button = document.getElementById('interest-btn-' + serviceId);
                    if (button) {
                        let newIsInterested = !isInterested;
                        localStorage.setItem('service-' + serviceId, newIsInterested);
                        updateButtonState(button, newIsInterested);

                        if (method === 'POST' && data.id) {
                            button.setAttribute('data-interested-service', JSON.stringify(data));
                        } else if (method === 'DELETE') {
                            button.setAttribute('data-interested-service', '');
                        }
                    }
                } else {
                    console.error("Failed to update interest status:", data);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function updateButtonState(button, isInterested) {
        button.classList.toggle('btn-danger', isInterested);
        button.classList.toggle('btn-primary', !isInterested);
        button.innerHTML = isInterested ? 'Uninterested' : 'Interested';
        console.log(`Button state updated. New state: ${isInterested ? 'Uninterested' : 'Interested'}`);
    }
</script>
</body>
</html>
