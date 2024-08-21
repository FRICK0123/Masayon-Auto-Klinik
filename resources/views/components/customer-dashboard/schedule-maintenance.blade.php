@props(['vehicle'])
<div class="container w-75 border border-2 shadow pt-3 pb-3">
    <h2 class="text-center">Schedule Maintenance for {{ $vehicle['model'] }}</h2>
    <p class="text-secondary">Note: you cannot change the details of this car once submitted</p>
    <form action="{{ route('schedule_maintenance_store') }}" method="post" class="container mt-3">
        @csrf
        <label for="maintenance_type" class="fw-bold">Maintenance Type:</label>
        <input type="text" placeholder="Enter type of Maintenance" name="maintenance_type" class="form-control" id="maintenance_type" required><br>

        <label for="maintenance_date" class="fw-bold">
            Maintenance Date: (current date or last maintenance date)
        </label>
        <input type="date" name="maintenance_date" id="maintenance_date" class="form-control">
        <br>
        <label for="scheduled_interval" class="fw-bold">Schedule Interval:</label>
        <select name="scheduled_interval" id="scheduled_interval" class="form-select">
            <option value="1">1 month</option>
            <option value="2">2 months</option>
            <option value="3">3 months</option>
            <option value="4">4 months</option>
            <option value="5">5 months</option>
            <option value="6">6 months</option>
            <option value="7">7 months</option>
            <option value="8">8 months</option>
            <option value="9">9 months</option>
            <option value="10">10 months</option>
            <option value="11">11 months</option>
            <option value="12">12 months</option>
        </select>
        <br>

        <input type="hidden" value="{{$vehicle['vehicleID']}}" name="vehicleID">

        <button class="btn btn-dark" type="">Submit</button>
    </form>
</div>