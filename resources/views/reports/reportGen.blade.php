<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }

        .logo-img {
            width: 250px; /* Adjust the logo width */
            max-width: 100%;
            display: block;
            margin: 0 auto;
        }

        .heading {
            font-size: 2rem;
            color: navy;
            font-weight: bold;
            text-transform: uppercase;
        }

        .text-gray {
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container text-center py-2">
        <img src="data:image/svg+xml;base64,<?php echo base64_encode(file_get_contents(base_path('public/images/RoadWatch Logo WB.png'))); ?>" class="logo-img mb-3" alt="RoadWatch Logo">
        <h1 class="heading">Summary of Completed Reports</h1>
    </div>

    @foreach($cityEngineers as $user)
        @foreach($reports as $report)
            @foreach($report->submissions as $submission && $report->status === 'FINISHED')
                @if($user->id === $report->assigned_user_id)
                    <div class="border rounded p-3 m-3">
                        <div class="container py-4">
                            <p class="text-gray"> Assigned City Engineer: {{ $user->name }} </p>
                            <p class="text-gray"> List of Personnel: 
                            @foreach (json_decode($submission->personnel) as $key => $person)
                                {{ $person }}
                                @if ($key < count(json_decode($submission->personnel)) - 1)
                                , 
                                @endif
                                @endforeach </p>
                            <p class="text-gray"> Report Name : {{ $report->name }} </p>
                            <p class="text-gray"> Address : {{ $report->address }} </p>
                            <p class="text-gray"> Details : {{ $report->details }} </p>
                            @foreach (json_decode($report->photo) as $image)
                                <p class="text-gray"> Photo : </p>
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($image))) }}" class="app-image-style"/>
                            @endforeach
                            <p class="text-gray"> Severity : {{ $report->severity }} </p>
                            <p class="text-gray"> Urgency : {{ $report->urgency }} </p>
                            <p class="text-gray"> Status : {{ $report->status }} </p>
                            <p class="text-gray"> Started Date : {{ $report->startDate }} Ended Date : {{ $report->targetDate }} </p>
                        </div>
                        
                        @foreach($submission->submissionsUpdate as $updates)
                        <div class="border rounded p-3 m-3">
                            <p class="text-gray"> Updated at : {{ $updates->created_at }} </p>
                            <p class="text-gray"> Actions Taken :
                            @foreach ($updates->actionsTakenArray() as $action)
                            <li>
                                <input type="checkbox" disabled {{ in_array($action, $updates->actionsTakenArray()) ? 'checked' : '' }}>
                                {{ $action }}
                            </li>  
                            @endforeach
                        <p class="text-gray"> Remarks :
                            {{ $updates->remarks }}
                        </p>
                        @foreach (json_decode($updates->photo) as $image)
                                <p class="text-gray"> Updated Photo : </p>
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($image))) }}" class="app-image-style"/>
                        @endforeach
                        @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @endforeach
    @endforeach




    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>