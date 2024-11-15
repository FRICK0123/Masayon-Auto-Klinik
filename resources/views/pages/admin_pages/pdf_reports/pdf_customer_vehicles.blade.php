<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Vehicles Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 5px; text-align: left; }
        h1 { text-align: center; }

        th,td{
            font-size: 10px;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('Images/Masayon Auto Klinik Logo.png') }}" alt="Masayon Logo" width="100">
    <h1>Customer Vehicles Report</h1>
    <p>Date: {{Carbon\Carbon::parse(now())->format('F j, Y')}}</p>

    <p><strong>Total Vehicles: </strong>{{ $vehicleCount }}</p>

    <table>
        <thead>
            <tr>
                <th>VEHICLE</th>
                <th>OWNER</th>
                <th>MILEAGE</th>
                <th>ENGINE NUMBER</th>
                <th>VIN</th>
                <th>CHASSIS NUMBER</th>
                <th>PLATE NUMBER</th>
                <th>ENGINE TYPE</th>
                <th>DATE REGISTERED</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->make }} {{ $vehicle->model }} {{ $vehicle->year_of_manufacture }}</td>
                    <td>{{ $vehicle->customer->fullname }}</td>
                    <td>{{ $vehicle->milage }}</td>
                    <td>{{ $vehicle->engine_number }}</td>
                    <td>{{ $vehicle->vehicle_identification_number }}</td>
                    <td>{{ $vehicle->chassis_number }}</td>
                    <td>{{ $vehicle->plate_number }}</td>
                    <td>{{ $vehicle->engine_type }}</td>
                    <td>{{ Carbon\Carbon::parse($vehicle->created_at)->format('F j, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
