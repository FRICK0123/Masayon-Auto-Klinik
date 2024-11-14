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
            <a href="#" class="btn btn-dark btn-sm">View Details</a>
            <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancel" data-maintenanceID="{{ $schedule->maintenanceID }}" onclick="populateModal(this)">Cancel</a>
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
    function populateModal(element){
      const maintenanceID = element.getAttribute('data-maintenanceID');

      document.getElementById('cancelForm').action=`/cancel/${maintenanceID}`;
    }
</script>