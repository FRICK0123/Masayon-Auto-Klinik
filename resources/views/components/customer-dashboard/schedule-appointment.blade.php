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
        <div class="card shadow-sm">
            <div class="card-body">
            <h4 class="card-title">{{$schedule->vehicle->make}} {{$schedule->vehicle->model}} {{$schedule->vehicle->year_of_manufacture}}</h4>
            <p><strong>Maintenance Type:</strong> {{ $schedule->maintenance_type }}</p>
            <p><strong>Status:</strong> <span class="badge bg-warning">Pending</span></p>
            <p><strong>Appointment Date:</strong> {{ \Carbon\Carbon::parse($schedule->appointment_date)->format('F j, Y') }}</p>
            <a href="#" class="btn btn-primary btn-sm">View Details</a>
            </div>
        </div>
    </div>
    @endforeach
  </div>
</div>