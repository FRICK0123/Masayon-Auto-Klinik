<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Schedule Maintenance</title>
    <link rel="stylesheet" href="{{asset('css/customer_dashboard.css')}}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    <!--Bootstrap CDN Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <!--Preloader-->
        <x-preloader/>
    <!--End-->

    <!--Header-->
        <header>
            <x-customer-dashboard.navbar/>
        </header>
    <!--Header end-->
    
    <!--Main Content-->
        <main>            
            <x-customer-dashboard.mobile-canvas/>
            <x-customer-dashboard.main-content>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Vehicle Make</th>
                            <th>Vehicle Model</th>
                            <th>Maintenance Type</th>
                            <th>Scheduled Interval</th>
                            <th>Next Maintenance</th>
                            <th>Last Maintenance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
                            <tr>
                                <td>{{ $schedule['make'] }}</td> <!-- Access the make from the related vehicle -->
                                <td>{{ $schedule['model'] }}</td> <!-- Access the model from the related vehicle -->
                                <td>{{ $schedule['maintenance_type'] }}</td>
                                <td>{{ $schedule['scheduled_interval'] }} months</td>
                                <td>{{ \Carbon\Carbon::parse($schedule['scheduled_date'])->format('F j, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule['last_maintenance_date'])->format('F j, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-customer-dashboard.main-content>
        </main>
    <!--End-->
</body>
</html>