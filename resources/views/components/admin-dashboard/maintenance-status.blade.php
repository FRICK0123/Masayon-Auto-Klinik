@props(['schedules'])

<div class="container">
    <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm">
        <h5 class="pt-2">MAINTENANCE STATUS</h5>

        <form action="{{ route('search_maintenance_status') }}" method="GET" class="search-box me-2">
            @csrf
            <button class="btn-search" type="button"><img src="{{ asset('icons/magnifying-glass-white.svg') }}" alt="Search Appointment" width="30"></button>
            <input type="text" class="input-search" placeholder="Search" name="search_schedule">
        </form>
    </div>

    <div class="container mt-3 table-responsive">
    <!--Cars table-->
            <table class="table table-striped">
                <tr>
                    <th>VEHICLE</th>
                    <th>OWNER</th>
                    <th>MAINTENANCE TYPE</th>
                    <th>SCHEDULED DATE</th>
                    <th>SCHEDULED MILAGE</th>
                    <th>STATUS</th>
                    <th></th>
                </tr>

                @foreach ($schedules as $schedule)
                    @if ($schedule->isAppointed == 1 && $schedule->isDeactivated == 0)
                        <tr>
                            <td>{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} ({{ $schedule->vehicle->year_of_manufacture }})</td>
                            <td>{{ $schedule->vehicle->customer->fullname }}</td>
                            <td>{{ $schedule->maintenance_type }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F j, Y') }}</td>
                            <td>{{ $schedule->next_milage_schedule }}</td>
                            <td><span class="badge text-bg-warning">Pending...</span></td>
                            <td>
                                <div class="dropdown" style="position: static;">
                                    <button class="btn btn-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#view_schedule"
                                                data-view-owner="{{ $schedule->vehicle->customer->fullname }}"
                                                data-view-vehicle="{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} {{ $schedule->vehicle->year_of_manufacture }}"
                                                data-view-maintenance-type="{{ $schedule->maintenance_type }}"
                                                data-view-pms-services="{{ $schedule->PMS_services }}"
                                                data-view-scheduled-date="{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F j, Y') }}"
                                                data-view-last-maintenance-date="{{ \Carbon\Carbon::parse($schedule->last_maintenance_date)->format('F j, Y') }}"
                                                data-view-scheduled-interval="{{ $schedule->scheduled_interval }}"
                                                data-view-oil-type="{{ $schedule->oil_type }}"
                                                data-view-current-milage="{{ $schedule->vehicle->milage }}"
                                                data-view-next-milage-schedule="{{ $schedule->next_milage_schedule }}"
                                                onclick="populateModal(this)">View</a></li>
                                        <li><a class="dropdown-item" href="#" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#update"
                                            data-maintenance-id="{{ $schedule->maintenanceID }}"
                                            data-vehicle-id="{{ $schedule->vehicle->vehicleID }}"
                                            data-customer-id="{{ $schedule->vehicle->customer->customerID }}"
                                            data-owner="{{ $schedule->vehicle->customer->fullname }}"
                                            data-vehicle="{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} {{ $schedule->vehicle->year_of_manufacture }}"
                                            data-previous-milage="{{ $schedule->vehicle->milage }}"
                                            data-maintenance-type="{{ $schedule->maintenance_type }}"
                                            data-oil-type="{{ $schedule->oil_type }}"
                                            data-scheduled-interval="{{ $schedule->scheduled_interval }}"
                                            onclick="fillData(this)">
                                                Add
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item"
                                            data-bs-toggle="modal"
                                            data-bs-target="#cancel"
                                            data-maintenanceID="{{ $schedule->maintenanceID }}"
                                            onclick="populateCancel(this)">Cancel</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>   
                    @endif
                @endforeach
            </table>
        <!--End-->
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="update" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Maintenance</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('maintenance_status_update') }}" method="post">
            @csrf
            <label for="current_milage" class="fw-bold">Enter Current Mileage:</label>
            <input type="number" placeholder="miles" class="form-control" id="current_milage" name="current_milage"><br><br>

            <label for="cost" class="fw-bold">Enter Maintenance Cost:</label>
            <div class="input-group mb-3">
                <span class="input-group-text">₱</span>
                <input type="number" class="form-control" name="cost" id="cost">
            </div><br>

            <label for="date_performed" class="fw-bold">Date Performed:</label>
            <input type="date" class="form-control" name="date_performed" id="date_performed"><br>

            <label for="maintenance_description" class="form-label fw-bold">Enter Maintenance Description</label>
            <textarea class="form-control" id="maintenance_description" rows="3" name="maintenance_description"></textarea><br><br>

            <input type="hidden" id="maintenance_id" name="maintenance_id">
            <input type="hidden" id="vehicle_id" name="vehicle_id">
            <input type="hidden" id="customer_id" name="customer_id">
            <input type="hidden" id="owner" name="owner">
            <input type="hidden" id="vehicle" name="vehicle">
            <input type="hidden" id="previous_milage" name="previous_milage">
            <input type="hidden" id="maintenance_type" name="maintenance_type">
            <input type="hidden" id="scheduled_interval" name="scheduled_interval">
            <input type="hidden" id="oil_type" name="oil_type">

            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Mark as Completed</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- View Maintenance Schedule Modal -->
<div class="modal fade" id="view_schedule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Maintenance Schedule</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <label class="fw-bold">Owner:</label>
            <p id="view_owner"></p>
                        
            <label class="fw-bold">Vehicle:</label>
            <p id="view_vehicle"></p>

            <label class="fw-bold">Maintenance Type:</label>
            <p id="view_maintenance_type"></p>

            <label class="fw-bold">PMS Services:</label>
            <p id="view_pms_services"></p>

            <label class="fw-bold">Scheduled Date:</label>
            <p id="view_scheduled_date"></p>

            <label class="fw-bold">Last Maintenance Date:</label>
            <p id="view_last_maintenance_date"></p>

            <label class="fw-bold">Schedule Interval:</label>
            <p id="view_schedule_interval"></p>

            <label class="fw-bold">Oil Type:</label>
            <p id="view_oil_type"></p>

            <label class="fw-bold">Current Mileage:</label>
            <p id="view_current_milage"></p>

            <label class="fw-bold">Next Mileage Schedule:</label>
            <p id="view_next_milage_schedule"></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<!-- cancel Modal -->
<div class="modal fade" id="cancel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Cancel this Appointment?</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>You won't be able to recover this appointment!</p>
        </div>
        <div class="modal-footer">
            <form action="{{ route('cancel_appointment') }}" method="GET">
                <input type="hidden" name="maintenanceID" id="maintenanceID">
                <button type="submit" class="btn btn-outline-dark">Confirm</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!--Maintenance Task Added Toast Notification -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="appointmentAdded" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success">
            <strong class="me-auto text-light">Masayon Auto Klinik</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('appointment') }}
        </div>
    </div>
</div>

<!--Javascript-->
    <script>
        function fillData(element){
            //get data from link
            const maintenance_id = element.getAttribute('data-maintenance-id');
            const vehicle_id = element.getAttribute('data-vehicle-id');
            const customer_id = element.getAttribute('data-customer-id');
            const owner = element.getAttribute('data-owner');
            const vehicle = element.getAttribute('data-vehicle');
            const previous_milage = element.getAttribute('data-previous-milage');
            const maintenance_type = element.getAttribute('data-maintenance-type');
            const scheduled_interval = element.getAttribute('data-scheduled-interval');
            const oil_type = element.getAttribute('data-oil-type');

            //fill input values
            document.getElementById('maintenance_id').value = maintenance_id;
            document.getElementById('vehicle_id').value = vehicle_id;
            document.getElementById('customer_id').value = customer_id;
            document.getElementById('owner').value = owner;
            document.getElementById('vehicle').value = vehicle;
            document.getElementById('previous_milage').value = previous_milage;
            document.getElementById('maintenance_type').value = maintenance_type;
            document.getElementById('scheduled_interval').value = scheduled_interval;
            document.getElementById('oil_type').value = oil_type;
        }

        function populateModal(element){
            const owner = element.getAttribute('data-view-owner');
            const vehicle = element.getAttribute('data-view-vehicle');
            const maintenance_type = element.getAttribute('data-view-maintenance-type');
            const pms_services = element.getAttribute('data-view-pms-services');
            const scheduled_date = element.getAttribute('data-view-scheduled-date');
            const last_maintenance_date = element.getAttribute('data-view-last-maintenance-date');
            const schedule_interval = element.getAttribute('data-view-scheduled-interval');
            const oil_type = element.getAttribute('data-view-oil-type');
            const current_milage = element.getAttribute('data-view-current-milage');
            const next_milage_schedule = element.getAttribute('data-view-next-milage-schedule');

            document.getElementById('view_owner').innerHTML = owner;
            document.getElementById('view_vehicle').innerHTML = vehicle;
            document.getElementById('view_maintenance_type').innerHTML = maintenance_type;
            document.getElementById('view_pms_services').innerHTML = pms_services;
            document.getElementById('view_scheduled_date').innerHTML = scheduled_date;
            document.getElementById('view_last_maintenance_date').innerHTML = last_maintenance_date;
            document.getElementById('view_schedule_interval').innerHTML = schedule_interval;
            document.getElementById('view_oil_type').innerHTML = oil_type;
            document.getElementById('view_current_milage').innerHTML = current_milage;
            document.getElementById('view_next_milage_schedule').innerHTML = next_milage_schedule;
        }

        function populateCancel(element){
            const maintenanceID = element.getAttribute('data-maintenanceID');

            document.getElementById('maintenanceID').value = maintenanceID;
        }

    // Check if there's an appointment added message in session
    @if (session('appointment'))
        // Show the toast
        var toastEl = new bootstrap.Toast(document.getElementById('appointmentAdded'));
        toastEl.show();
    @endif
    </script>
<!--end-->