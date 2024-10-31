    <!--Top Level of the dashboard content-->
        <div class="container">
            <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm mb-3 border">
                <h5 class="pt-2">Vehicles</h5>
                
                <form action="{{route('car_view')}}" method="GET">
                    <button class="btn btn-dark"><img src="{{ asset('icons/car_white.svg') }}" alt="Add Car" width="25"> Add Car</button>
                </form>
            </div>

            
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
                        <form action="{{ route('view_car_details',$item['vehicleID']) }}" method="GET" class="card shadow border border-dark" style="height: 400px; width: 100%; overflow: hidden;">
                            @csrf
                            <img src="{{asset('Images/car_images/'.$item['vehicle_image'])}}" alt="Car Photo" style="height: 200px; width: 100%; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h4 class="text-dark">{{$item['make']}} {{$item['model']}} {{ $item['year_of_manufacture'] }}</h4>
                                <p class="text-dark"><label class="fw-bold">Engine Type:</label> {{ $item['engine_type'] }}</p>
                                <p class="text-dark"><label class="fw-bold">Plate Number:</label> {{$item['plate_number']}}</p>
                                <button class="btn btn-dark align-self-end rounded-0">View</button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    <!--End-->
