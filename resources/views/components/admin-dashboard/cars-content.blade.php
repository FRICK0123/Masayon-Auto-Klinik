@props(['cars'])

<div class="container">
    <h2 class="pb-2 border-bottom">CARS</h2>

    <!--Functionalities-->
        <div class="d-flex justify-content-between">
            <form action="{{ route('car_form') }}" method="get">
                <button class="btn btn-dark"><small>+ ADD CAR </small></button>
            </form>

            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{asset('icons/funnel.svg')}}" alt="Filter">
                </button>
                <form id="carFilterForm" action="{{ route('car_filter') }}" method="GET" class="dropdown-menu p-2">
                    <input type="radio" id="by_make" name="filter_cars" class="form-check-input border border-1 border-dark" value="by_make">
                    <label for="by_make" class="ms-2">By Make</label><br><br>

                    <input type="radio" id="by_model" name="filter_cars" class="form-check-input border border-1 border-dark" value="by_model">
                    <label for="by_model" class="ms-2">By Model</label><br><br>

                    <input type="radio" id="by_year" name="filter_cars" class="form-check-input border border-1 border-dark" value="by_year">
                    <label for="by_year" class="ms-2">By Year</label><br><br>

                    <button type="submit" class="btn btn-dark">Filter</button>
                </form>
            </div>
        </div>
    <!--end-->

    <!--Cars table-->
    <div id="carTableContainer">
        <table class="table table-striped table-responsive">
            <tr>
                <th>CAR IMAGE</th>
                <th>MAKE</th>
                <th>MODEL</th>
                <th>YEAR</th>
                <th>ENGINE TYPE</th>
                <th></th>
            </tr>
            @foreach ($cars as $car)
                <tr>
                    <td><img src="{{ asset('Images/car_images/'.$car['car_image']) }}" alt="Car Image" width="100" height="100"></td>
                    <td>{{ $car['car_make'] }}</td>
                    <td>{{ $car['car_model'] }}</td>
                    <td>{{ $car['year_of_manufacture'] }}</td>
                    <td>{{ $car['engine_type'] }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item bg-danger text-light" href="#">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <!--End-->
</div>