<div class="ps-1 pe-1 pt-5 p-lg-0">
    <!--Top Level of the dashboard content-->
        <div class="container d-flex justify-content-between align-items-center">
            <form action="{{route('car_view')}}" method="GET">
                    <button class="btn btn-light">+<img src="{{ asset('icons/car.svg') }}" alt="Add Car"></button>
            </form>
            
            {{-- <form action="#" method="POST">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search Car">
                    <button class="input-group-text btn btn-dark">Search</button>
                </div>
            </form> --}}
        </div>
    <!--End-->

    <!--Main Content-->
        <div class="container mt-3">
            <div class="row">
                @props(['vehicles'])
                @foreach ($vehicles as $item)
                    <div class="col-md-4 mt-3">
                        <form action="{{ route('view_car_details',$item['vehicleID']) }}" method="GET" class="card shadow" style="height: 400px; width: 100%; overflow: hidden;">
                            @csrf
                            <img src="{{asset('Images/car_images/'.$item['vehicle_image'])}}" alt="Car Photo" style="height: 200px; width: 100%; object-fit: cover;">
                            <div class="card-body d-flex flex-column bg-dark">
                                <h4 class="text-light">{{$item['make']}} {{$item['model']}} {{ $item['year_of_manufacture'] }}</h4>
                                <p class="text-light"><label class="fw-bold">Engine Type:</label> {{ $item['engine_type'] }}</p>
                                <p class="text-light"><label class="fw-bold">Plate Number:</label> {{$item['plate_number']}}</p>
                                <button class="btn btn-light align-self-end">View</button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    <!--End-->
</div>