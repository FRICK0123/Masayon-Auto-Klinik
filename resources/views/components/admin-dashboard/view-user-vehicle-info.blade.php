@props(['vehicles','customer'])
<div class="container">
    <h2 class="pb-2 border-bottom">{{ $customer['fullname'] }} VEHICLES</h2>

    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th>IMAGE</th>
                <th>MAKE</th>
                <th>MODEL</th>
                <th>YEAR OF MANUFACTURE</th>
                <th>ENGINE TYPE</th>
                <th></th>
            </tr>

            @foreach ($vehicles as $vehicle)
                <tr>
                    <td><img src="{{asset('Images/car_images/'.$vehicle['vehicle_image'])}}" alt="Vehicle Image" width="100" height="100" style="border-radius: 50%"></td>
                    <td>{{ $vehicle['make'] }}</td>
                    <td>{{ $vehicle['model'] }}</td>
                    <td>{{ $vehicle['year_of_manufacture'] }}</td>
                    <td>{{ $vehicle['engine_type'] }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#view_vehicle"
                                    data-vehicle-image="{{ asset('Images/car_images/'.$vehicle['vehicle_image']) }}"
                                    data-make="{{ $vehicle['make'] }}"
                                    data-model="{{ $vehicle['model'] }}"
                                    data-year="{{ $vehicle['year_of_manufacture'] }}"
                                    data-milage="{{ $vehicle['milage'] }}"
                                    data-engine-number="{{ $vehicle['engine_number'] }}"
                                    data-vin="{{ $vehicle['vehicle_identification_number'] }}"
                                    data-chassis="{{ $vehicle['chassis_number'] }}"
                                    data-plate-number="{{ $vehicle['plate_number'] }}"
                                    data-engine-type="{{ $vehicle['engine_type'] }}"
                                    onclick="populateModal(this)">View</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('walkin_maintenance_view',$vehicle['vehicleID']) }}">Walk In</a></li>
                                <li><a class="dropdown-item" href="{{ route('add_user_vehicle_maintenance_schedule_view',$vehicle['vehicleID']) }}">Schedule a Maintenance</a></li>
                                <li><a class="dropdown-item bg-danger text-light" href="#" data-bs-toggle="modal" data-bs-target="#delete_car" data-vehicleID="{{ $vehicle['vehicleID'] }}" onclick="deleteVehicle(this)">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<!--View Vehicle Modal-->
<div class="modal fade" id="view_vehicle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Vehicle Info</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
            <img src="" id="user_vehicle_image" width="200" height="200" style="border-radius: 50%;">
            <div class="car_info">
                <div>
                    <span class="d-flex">
                        <p class="fw-bold">Make: &nbsp;</p>
                        <p id="make"></p>
                    </span>
                    
                    <span class="d-flex">
                        <p class="fw-bold">Model: &nbsp;</p>
                        <p id="model"></p>
                    </span>

                    <span class="d-flex">
                        <p class="fw-bold">Year of Manufacture: &nbsp;</p>
                        <p id="year_of_manufacture"></p>
                    </span>

                    <span class="d-flex">
                        <p class="fw-bold">Current Mileage: &nbsp;</p>
                        <p id="milage"></p>
                    </span>

                    <span class="d-flex">
                        <p class="fw-bold">Engine Number: &nbsp;</p>
                        <p id="engine_number"></p>
                    </span>

                    <span class="d-flex">
                        <p class="fw-bold">VIN: &nbsp;</p>
                        <p id="vin"></p>
                    </span>

                    <span class="d-flex">
                        <p class="fw-bold">Chassis Number: &nbsp;</p>
                        <p id="chassis_number"></p>
                    </span>

                    <span class="d-flex">
                        <p class="fw-bold">Plate Number: &nbsp;</p>
                        <p id="plate_number"></p>
                    </span>

                    <span class="d-flex">
                        <p class="fw-bold">Engine Type: &nbsp;</p>
                        <p id="engine_type"></p>
                    </span>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Delete Vehicle Modal -->
<div class="modal fade" id="delete_car" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Do you want to delete this car?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        The information and maintenance schedules associated with this car will also be deleted!
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="delete_car_form">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Toast Notification -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="vehicleAddedToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success">
            <strong class="me-auto text-light">Masayon Auto Klinik</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('vehicle_added') }}
        </div>
    </div>
</div>

<script>

    // Check if there's a vehicle added message in session
    @if (session('vehicle_added'))
        // Show the toast
        var toastEl = new bootstrap.Toast(document.getElementById('vehicleAddedToast'));
        toastEl.show();
    @endif
    function populateModal(element){
        //Get Data from clicked link
        const car_image = element.getAttribute('data-vehicle-image');
        const make = element.getAttribute('data-make');
        const model = element.getAttribute('data-model');
        const year = element.getAttribute('data-year');
        const milage = element.getAttribute('data-milage');
        const engine_number = element.getAttribute('data-engine-number');
        const vin = element.getAttribute('data-vin');
        const chassis = element.getAttribute('data-chassis');
        const plate_number = element.getAttribute('data-plate-number');
        const engine_type = element.getAttribute('data-engine-type');

        //Populate Modal
        document.getElementById('user_vehicle_image').src = car_image;
        document.getElementById('make').innerHTML = make;
        document.getElementById('model').innerHTML = model;
        document.getElementById('year_of_manufacture').innerHTML = year;
        document.getElementById('milage').innerHTML = milage;
        document.getElementById('engine_number').innerHTML = engine_number;
        document.getElementById('vin').innerHTML = vin;
        document.getElementById('chassis_number').innerHTML = chassis;
        document.getElementById('plate_number').innerHTML = plate_number;
        document.getElementById('engine_type').innerHTML = engine_type;
    }

    //delete customer vehicle
    function deleteVehicle(element){
        const vehicleID = element.getAttribute('data-vehicleID');

        document.getElementById('delete_car_form').action=`/delete_vehicle/${vehicleID}`;
    }
</script>