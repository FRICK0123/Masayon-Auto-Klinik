@props(['schedules'])

<div class="container">
    <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm mb-3">
        <h5 class="pt-2">Appointments</h5>
    </div>
  <!-- Grid layout with hoverable cards -->
  <div class="row">
    <!-- Card 1 -->
    @foreach ($schedules as $schedule)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card shadow-sm border border-dark bg-light" id="card">
            <div class="card-body">
            <h4 class="card-title">{{$schedule->vehicle->make}} {{$schedule->vehicle->model}} {{$schedule->vehicle->year_of_manufacture}}</h4>
            <p><strong>Maintenance Type:</strong> {{ $schedule->maintenance_type }}</p>
            <p><strong>Status:</strong> <span class="badge bg-warning">Pending</span></p>
            <p><strong>Appointment Date:</strong> {{ \Carbon\Carbon::parse($schedule->appointment_date)->format('F j, Y g:i A') }}</p>
            <a href="#" class="btn btn-dark btn-sm"
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
            onclick="populateModal(this)">View Details</a>
            <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancel" data-maintenanceID="{{ $schedule->maintenanceID }}" onclick="cancelFunction(this)">Cancel</a>
            </div>

            <span class="top"></span>
            <span class="bottom"></span>
            <span class="left"></span>
            <span class="right"></span>
        </div>
    </div>
    @endforeach
  </div>
</div>

<!-- Cancel appointment modal -->
<div class="modal fade" id="cancel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Do you want to cancel this appointment?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>You won't be able to recover this appointment!</p>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="cancelForm">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-dark">yes</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">cancel</button>
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

    <!-- Bootstrap toast -->
    @if(session('success'))
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header bg-success">
            <strong class="me-auto text-light">Masayon Auto Klinik</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
            {{ session('success') }}
          </div>
        </div>
      </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toastEl = document.getElementById('liveToast');
        if (toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    });
    function cancelFunction(element){
      const maintenanceID = element.getAttribute('data-maintenanceID');

      document.getElementById('cancelForm').action=`/cancel/${maintenanceID}`;
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
                document.getElementById('view_schedule_interval').innerHTML = schedule_interval + " months";
                document.getElementById('view_oil_type').innerHTML = oil_type;
                document.getElementById('view_current_milage').innerHTML = current_milage;
                document.getElementById('view_next_milage_schedule').innerHTML = next_milage_schedule;

            }
</script>