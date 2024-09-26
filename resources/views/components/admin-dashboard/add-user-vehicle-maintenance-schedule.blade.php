@props(['vehicle'])
<div class="container w-75 border border-2 shadow pt-3 pb-3">
    <h2 class="text-center">Schedule Maintenance for {{ $vehicle['make'] }} {{ $vehicle['model'] }}</h2>
    <form action="{{ route('store_maintenance_schedule') }}" method="POST" class="container mt-3">
        @csrf
        <label for="maintenance_type" class="fw-bold">Maintenance Type:</label>
        <select name="maintenance_type" id="maintenance_type" class="form-select">
            <option value="" disabled selected>Select Maintenance Type</option>
            <option value="EGR Cleaning">EGR Cleaning</option>
            <option value="Throttle Body & Intake Manifold Cleaning">Throttle Body & Intake Manifold Cleaning</option>
            <option value="Wheel Balance">Wheel Balance</option>
            <option value="Wheel Alignment">Wheel Alignment</option>
            <option value="Check Brake">Check Brake</option>
            <option value="Oil Change">Change Oil/Oil Filter</option>
            <option value="Car Checkup & Repair">Car Checkup & Repair</option>
            <option value="Check Concerns">Check Concerns</option>
            <option value="Check up">Check up</option>
            <option value="Basic PMS">Basic PMS</option>
            <option value="Full PMS">Heavy PMS</option>
        </select><br>

        <label for="maintenance_date" class="fw-bold">
            Maintenance Date: (current date or last maintenance date)
        </label>
        <input type="date" name="maintenance_date" id="maintenance_date" class="form-control">
        <br>

        <div class="container_fluid" id="oil_type_container" style="display: none">
            <label for="oil_type" class="fw-bold">Oil Type:</label>
            <select name="oil_type" id="oil_type" class="form-select">
                <option value="" disabled selected>Select Oil Type</option>
                <option value="Mobil Delvac I 5W-40 Fully Synthetic Diesel Oil" data-mileage="8000">Mobil Delvac I 5W-40 Fully Synthetic Diesel Oil</option>
                <option value="Mobil Delvac 15W-40 Semi Synthetic Diesel Oil" data-mileage="5000">Mobil Delvac 15W-40 Semi Synthetic Diesel Oil</option>
                <option value="Mobil Super 5W-30 Fully Synthetic Gasoline Oil" data-mileage="8000">Mobil Delvac 15W-40 Semi Synthetic Diesel Oil</option>
                <option value="Mobil Special 20w-50 Ordinary Gasoline Oil" data-mileage="5000">Mobil Special 20w-50 Ordinary Gasoline Oil</option>
            </select><br>

            <label for="mileage_interval" class="fw-bold">Mileage Interval (mi)</label>
            <input type="number" name="mileage_interval" id="mileage_interval" readonly class="form-control"><br>
        </div>

        <div class="container_fluid" id="schedule_interval_container">
            <label for="scheduled_interval" class="fw-bold">Schedule Interval:</label>
            <select name="scheduled_interval" id="scheduled_interval" class="form-select">
                <option value="" disabled selected>Select Month Interval</option>
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
        </div>

        <div class="container_fluid" id="schedule_interval_pms" style="display: none">
            <label for="scheduled_interval" class="fw-bold">Schedule Interval:</label>
            <select name="scheduled_interval" id="scheduled_interval" class="form-select">
                <option value="" disabled selected>Select Month Interval</option>
                <option value="12">1 year</option>
                <option value="24">2 year</option>
                <option value="36">3 year</option>
                <option value="48">4 years</option>
                <option value="60">5 years</option>
            </select>
            <br>
        </div>

        <input type="hidden" value="{{$vehicle['vehicleID']}}" name="vehicleID">
        <input type="hidden" value="{{ $vehicle['milage'] }}" name="milage">

        <button class="btn btn-dark" type="submit">Submit</button>
    </form>
</div>

<script>
    let maintenance_type = document.getElementById('maintenance_type');
    let oil_type_select = document.getElementById('oil_type');
    let mileage_interval_input = document.getElementById('mileage_interval');

    // Show oil type container when 'Oil Change' is selected
    maintenance_type.addEventListener('change', function() {
        if (maintenance_type.value === "Oil Change") {
            document.getElementById('oil_type_container').style.display = "block";
            document.getElementById('schedule_interval_pms').style.display = "none";
            document.getElementById('schedule_interval_container').style.display = "block";
        } else if(maintenance_type.value === "Full PMS"){
            document.getElementById('schedule_interval_pms').style.display = "block";
            document.getElementById('schedule_interval_container').style.display = "none";
            document.getElementById('oil_type_container').style.display = "none";
        } else if(maintenance_type.value === "EGR Cleaning"){
            document.getElementById('oil_type_container').style.display = "none";
            document.getElementById('schedule_interval_pms').style.display = "none";
            document.getElementById('schedule_interval_container').style.display = "none";
        }
        else{
            document.getElementById('oil_type_container').style.display = "none";
            document.getElementById('schedule_interval_pms').style.display = "none";
            document.getElementById('schedule_interval_container').style.display = "block";
            mileage_interval_input.value = ""; // Clear the mileage interval when hidden
        }
    });

    // Populate the mileage interval based on the selected oil type
    oil_type_select.addEventListener('change', function() {
        let selectedOption = oil_type_select.options[oil_type_select.selectedIndex];
        let mileage = selectedOption.getAttribute('data-mileage');
        
        if (mileage) {
            mileage_interval_input.value = mileage;
        } else {
            mileage_interval_input.value = ""; // Clear the field if no valid option is selected
        }
    });
</script>