<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Reports</title>
    <link rel="stylesheet" href="{{asset('css/admin_dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('css/table_style.css')}}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    <!--Bootstrap CDN Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!--Preloader-->
        <x-preloader/>
    <!--End-->
    <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Do you want to log out?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger">Log out</button>
                </form>
            </div>
            </div>
        </div>
        </div>
    <!--end-->

    <!--Header-->
        <header style="position: fixed; width: 100%; z-index: 100;">
            <x-admin-dashboard.header/>
        </header>
    <!--Header end-->

    <!--Main Content-->
    <main>
        <x-admin-dashboard.admin-content>
            <div class="container">
                <div class="d-flex justify-content-between align-items-center pb-3 bg-white p-3 rounded-3 shadow-sm mb-4">
                    <h4 class="pt-2 fw-bold">CUSTOMER VEHICLES</h4>

                    <div class="d-flex align-items-center">
                        <form action="#" method="GET" class="search-box me-2">
                            @csrf
                            {{-- <input type="text" class="form-control rounded-5" placeholder="Search Customers" name="search_customers" autocomplete="off"> --}}
                            <button class="btn-search" type="button"><img src="{{ asset('icons/magnifying-glass-white.svg') }}" alt="Search Customer" width="30"></button>
                            <input type="text" class="input-search" placeholder="Search Vehicle">
                        </form>
                    </div>
                </div>

                <div class="container">
                    @php
                        $vehicleCount=$vehicles->count();
                    @endphp
                    <h6>Number of Vehicles: {{ $vehicleCount }}</h6>

                    <div class="d-flex align-items-center">
                        <form action="{{ route('customer_vehicles_view') }}" method="GET" class="d-flex">
                            @csrf
                            <select name="make" class="form-select me-2" onchange="this.form.submit()">
                                <option value="">Select Make</option>
                                @foreach ($makes as $make)
                                    <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>{{ $make }}</option>
                                @endforeach
                            </select>
                            
                            <select name="model" class="form-select me-2" onchange="this.form.submit()">
                                <option value="">Select Model</option>
                                @foreach ($models as $model)
                                    <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>{{ $model }}</option>
                                @endforeach
                            </select>

                            <select name="year" class="form-select me-2" onchange="this.form.submit()">
                                <option value="">Select Year</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div><br>

                    <div id="carTableContainer" class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>VEHICLE</th>
                                    <th>OWNER</th>
                                    <th>MILEAGE</th>
                                    <th>DATE REGISTERED</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vehicles as $vehicle)
                                    <tr>
                                        <td>{{ $vehicle->make }} {{ $vehicle->model }} {{ $vehicle->year_of_manufacture }}</td>
                                        <td>{{ $vehicle->customer->fullname }}</td>
                                        <td>{{ $vehicle->milage }}</td>
                                        <td>{{Carbon\Carbon::parse($vehicle->created_at)->format('F j, Y')}}</td>
                                        <td><button class="btn btn-dark btn-sm rounded-pill">View</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </x-admin-dashboard.admin-content>
    </main>
    <!--End-->
</body>

</html>