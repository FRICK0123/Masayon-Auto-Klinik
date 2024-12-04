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
                        <form action="{{ route('view_car_details',$item['vehicleID']) }}" method="GET" class="card shadow border border-dark" style="height: 450px; width: 100%; overflow: hidden;" id="card">
                            @csrf
                            <img src="{{asset('Images/car_images/'.$item['vehicle_image'])}}" alt="Car Photo" style="height: 200px; width: 100%; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h4 class="text-dark">{{$item['make']}} {{$item['model']}} {{ $item['year_of_manufacture'] }}</h4>
                                <p class="text-dark"><label class="fw-bold">Engine Type:</label> {{ $item['engine_type'] }}</p>
                                <p class="text-dark"><label class="fw-bold">Plate Number:</label> {{$item['plate_number']}}</p>

                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <a href="{{ route('schedule_maintenance_form',$item['vehicleID']) }}" class="btn btn-outline-dark w-100">Set Appointment</a>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <button class="btn btn-dark w-100" type="submit">View</button>
                                    </div>
                                </div>
                            </div>
                            <span class="top"></span>
                            <span class="bottom"></span>
                            <span class="right"></span>
                            <span class="left"></span>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    <!--End-->

    <!-- Vehicle Deleted Toast Notification -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="vehicleDeletedToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success">
                <strong class="me-auto text-light">Masayon Auto Klinik</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('vehicle_deleted') }}
            </div>
        </div>
    </div>

<script>
        @if (session('vehicle_deleted'))
            // Show the toast
            var toastEl = new bootstrap.Toast(document.getElementById('vehicleDeletedToast'));
            toastEl.show();
        @endif
</script>
