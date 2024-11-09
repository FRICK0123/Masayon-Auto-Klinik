@props(['customer','vehicles','previous_maintenance'])
<div class="container">
    <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm mb-3">
        <h5 class="pt-2">User</h5>
    
        <button class="btn btn-dark" type="button" id="returnBtn">Return</button>
        </form>
    </div>

    <div class="container row">
        <div class="col-md-4 border rounded-3 p-2">
            <!--Profile Image-->
            <div class="customer_img_wrapper mt-1">
                <img src="{{ asset('Images/profile_images/'.$customer['profile_img']) }}" alt="Car Image" class="customer_image" id="car_image">
            </div>

            <small class="fw-bold me-2">Fullname:</small>
            <p class="border-bottom" style="text-overflow: ellipsis; overflow:hidden;">{{ $customer['fullname'] }}</p>

            <small class="fw-bold me-2">Email:</small>
            <p class="border-bottom" style="text-overflow: ellipsis; overflow:hidden;">{{ $customer['email'] }}</p>

            <small class="fw-bold me-2">Phone Number:</small>
            <p class="border-bottom" style="text-overflow: ellipsis; overflow:hidden;">+63{{ $customer['phone_number'] }}</p>

            <small class="fw-bold me-2">Username:</small>
            <p class="border-bottom" style="text-overflow: ellipsis; overflow:hidden;">{{ $customer['username'] }}</p>

            <small class="fw-bold me-2">Account Status:</small>
            @if ($customer['isDeactivated'] == true)
                <p class="badge text-bg-danger">Deactivated</p>
            @elseif($customer['isDeactivated'] == false && $customer['isVerified'] == true)
                <p class="badge text-bg-success">Verified</p>
            @else
                <p class="badge text-bg-secondary">Not Verified</p>
            @endif

            <div class="d-flex">
                <form action="{{ route('view_user_vehicle_info',$customer['customerID']) }}" method="GET" class="me-2">
                    <button class="btn btn-primary" type="submit">View Vehicles</button>
                </form>
                <form action="{{ route('customer_maintenance_schedules',$customer['customerID']) }}" method="GET">
                    <button class="btn btn-dark" type="submit">View Schedules</button>
                </form>
            </div>
        </div>

        <div class="col-md-8 rounded-3 table-responsive border">
            <p class="fw-bold d-flex justify-content-between">
                {{ $customer['fullname'] }} Cars
                
                <form action="{{ route('add_vehicle_view',$customer['customerID']) }}" method="get">
                    <button class="btn btn-dark">+<img src="{{ asset('icons/car_white.svg') }}" alt="Add Car"></button>
                </form>
            </p>
            <table class="table">
                <tr>
                    <th><small>IMAGE</small></th>
                    <th><small>MAKE</small></th>
                    <th><small>MODEL</small></th>
                    <th><small>YEAR OF MANUFACTURE</small></th>
                    <th><small>ENGINE TYPE</small></th>
                </tr>

                @foreach ($vehicles as $vehicle)
                    <tr>
                        <td><a href="{{ asset('Images/car_images/'.$vehicle['vehicle_image']) }}" target="_blank"><img src="{{ asset('Images/car_images/'.$vehicle['vehicle_image']) }}" alt="Vehicle Image" width="80" height="80" style="border-radius: 50%;"></a></td>
                        <td>{{ $vehicle['make'] }}</td>
                        <td>{{ $vehicle['model'] }}</td>
                        <td>{{ $vehicle['year_of_manufacture'] }}</td>
                        <td>{{ $vehicle['engine_type'] }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
  
    <div class="container border border-1 shadow pb-3 mt-4 table-responsive">
        <h5>Previous Owner Transactions</h5>
        <table class="table">
            <tr>
                <th>VEHICLE</th>
                <th>MAINTENANCE TYPE</th>
                <th>COST</th>
                <th>DATE PERFORMED</th>
                <th></th>
            </tr>

            @foreach ($previous_maintenance as $item)
                <tr>
                    <td>{{ $item->vehicle }}</td>
                    <td>{{ $item->owner }}</td>
                    <td>{{ $item->maintenance_type }}</td>
                    <td>₱{{ number_format($item->cost, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->date_performed)->format('F j, Y') }}</td>
                    <td>
                        <button class="btn btn-dark btn-sm rounded-pill" 
                        data-bs-toggle="modal" 
                        data-bs-target="#view_transaction"
                        data-owner="{{ $item['owner'] }}"
                        data-vehicle="{{ $item['vehicle'] }}"
                        data-previous-milage="{{ $item['previous_milage'] }}"
                        data-current-milage="{{ $item['current_milage'] }}"
                        data-maintenance-type="{{ $item['maintenance_type'] }}"
                        data-oil-type="{{ $item['oil_type'] }}"
                        data-pms-services="{{ $item['pms_services'] }}"
                        data-cost="{{ $item['cost'] }}"
                        data-date-performed="{{ \Carbon\Carbon::parse($item->date_performed)->format('F j, Y') }}"
                        data-maintenance-description="{{ $item['maintenance_description'] }}"
                        onclick="populateModal(this)">View</button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<!--View Transaction-->
<div class="modal fade" id="view_transaction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction Information</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label class="fw-bold">Owner:</label>
        <p id="owner"></p>

        <label class="fw-bold">Vehicle:</label>
        <p id="vehicle"></p>

        <label class="fw-bold">Previous Mileage:</label>
        <p id="previous_milage"></p>

        <label class="fw-bold">Current Mileage:</label>
        <p id="current_milage"></p>

        <label class="fw-bold">Maintenance Type:</label>
        <p id="maintenance_type"></p>

        <label class="fw-bold" id="oil_type_label">Oil Type:</label>
        <p id="oil_type"></p>

        <label class="fw-bold" id="pms_label">PMS Services:</label>
        <p id="pms_services"></p>


        <label class="fw-bold">Cost:</label>
        <p id="cost"></p>

        <label class="fw-bold">Date Performed:</label>
        <p id="date_performed"></p>

        <label class="fw-bold">Maintenance Description:</label>
        <p id="maintenance_description"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    document.getElementById('returnBtn').addEventListener('click',function(){
        window.history.back();
    });

    function populateModal(element){
        const owner = element.getAttribute('data-owner');
        const vehicle = element.getAttribute('data-vehicle');
        const previous_milage = element.getAttribute('data-previous-milage');
        const current_milage = element.getAttribute('data-current-milage');
        const maintenance_type = element.getAttribute('data-maintenance-type');
        const oil_type = element.getAttribute('data-oil-type');
        const pms_services = element.getAttribute('data-pms-services');
        const cost = element.getAttribute('data-cost');
        const date_performed = element.getAttribute('data-date-performed');
        const maintenance_description = element.getAttribute('data-maintenance-description');

        document.getElementById('owner').innerHTML = owner;
        document.getElementById('vehicle').innerHTML = vehicle;
        document.getElementById('previous_milage').innerHTML = previous_milage;
        document.getElementById('current_milage').innerHTML = current_milage;
        document.getElementById('maintenance_type').innerHTML = maintenance_type;
        if(oil_type == ""){
            document.getElementById('oil_type_label').style.display = "none";
        }else{
            document.getElementById('oil_type_label').style.display = "block";
        }

        if(pms_services == ""){
            document.getElementById('pms_label').style.display = "none";
        }else{
            document.getElementById('pms_label').style.display = "block";
        }
        document.getElementById('oil_type').innerHTML = oil_type;
        document.getElementById('pms_services').innerHTML = pms_services;
        document.getElementById('cost').innerHTML = `₱ ${cost}`;
        document.getElementById('date_performed').innerHTML = date_performed;
        document.getElementById('maintenance_description').innerHTML = maintenance_description;
    }
</script>