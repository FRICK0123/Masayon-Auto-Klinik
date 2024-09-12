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
                <form action="#" method="POST" class="dropdown-menu p-2">
                    <input type="checkbox"><br>
                    <button>Filter</button>
                </form>
            </div>
        </div>
    <!--end-->

    <!--Cars table-->
        <table class="table table-striped table-responsive">
            <tr>
                <th>CAR IMAGE</th>
                <th>MAKE</th>
                <th>MODEL</th>
                <th>YEAR</th>
                <th>ENGINE TYPE</th>
            </tr>
            @foreach ($cars as $car)
                <tr>
                    <td>{{ $car['car_image'] }}</td>
                    <td>{{ $car['car_make'] }}</td>
                    <td>{{ $car['car_model'] }}</td>
                    <td>{{ $car['year_of_manufacture'] }}</td>
                    <td>{{ $car['engine_type'] }}</td>
                </tr>
            @endforeach
        </table>
    <!--End-->
</div>