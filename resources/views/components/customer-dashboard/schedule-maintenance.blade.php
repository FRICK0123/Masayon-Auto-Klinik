@props(['vehicle'])
<div class="container w-75 border border-2 shadow pt-3 pb-3">
    <h2 class="text-center">Schedule Maintenance for {{ $vehicle['make'] }} {{ $vehicle['model'] }}</h2>
    <p class="text-secondary">Note: you cannot change the details of this car once submitted</p>
    <form action="{{ route('schedule_maintenance_store') }}" method="post" class="container mt-3">
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

        <!--Basic PMS Service Type-->
            <div class="container" id="basic_pms_services">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="scanning">
                    <label class="form-check-label" for="scanning">
                        Scanning
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="change_oil">
                    <label class="form-check-label" for="change_oil">
                        Change Oil/Oil Filter
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="air_filter">
                    <label class="form-check-label" for="air_filter">
                        Air Filter
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="cabin_filter">
                    <label class="form-check-label" for="cabin_filter">
                        Cabin Filter
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="fuel_filter">
                    <label class="form-check-label" for="fuel_filter">
                        Fuel Filter
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="check_brakes">
                    <label class="form-check-label" for="check_brakes">
                        Check Brakes
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="check_concerns">
                    <label class="form-check-label" for="check_concerns">
                        Check Concerns
                    </label>
                </div>

            </div>
        <!--end-->

        <!--Full PMS Service Type-->
            <div class="container row" id="full_pms_services">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="full_change_oil">
                        <label class="form-check-label" for="full_change_oil">
                            Change Oil
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="replace_oil_filter">
                        <label class="form-check-label" for="replace_oil_filter">
                            Replace Oil Filter
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="replace_air_filter">
                        <label class="form-check-label" for="replace_air_filter">
                            Replace Air Filter
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="replace_fuel_filter_diesel">
                        <label class="form-check-label" for="replace_fuel_filter_diesel">
                            Replace Fuel Filter(Diesel)
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="replace_cabin_filter">
                        <label class="form-check-label" for="replace_cabin_filter">
                            Replace Cabin Filter
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="replace_transmission_oil">
                        <label class="form-check-label" for="replace_transmission_oil">
                            Replace Transmission Oil
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="replace_differential_oil">
                        <label class="form-check-label" for="replace_differential_oil">
                            Replace Differential Oil
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="inspect&cleaning_throttle_body">
                        <label class="form-check-label" for="inspect&cleaning_throttle_body">
                            Inspect & Cleaning Throttle Body
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="inspect&cleaning_brake_lining">
                        <label class="form-check-label" for="inspect&cleaning_brake_lining">
                            Inspect & Cleaning Brake Lining
                        </label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="inspect_steering_wheel">
                        <label class="form-check-label" for="inspect_steering_wheel">
                            Inspect Steering Wheel
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="inspect_linkage&gear_box">
                        <label class="form-check-label" for="inspect_linkage&gear_box">
                            Inspect Linkage & Gearbox
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="inspect_front&rear_suspension">
                        <label class="form-check-label" for="inspect_front&rear_suspension">
                            Inspect Front & Rear Suspension
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="inspect_battery_life">
                        <label class="form-check-label" for="inspect_battery_life">
                            Inspect Battery Life
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="inspect_clutch_system">
                        <label class="form-check-label" for="inspect_clutch_system">
                            Inspect Clutch System
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="inspect&replace_drive_belts">
                        <label class="form-check-label" for="inspect&replace_drive_belts">
                            Inspect & Replace Drive Belts
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="fluid_flushing">
                        <label class="form-check-label" for="fluid_flushing">
                            Fluid Flushing
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="full_scanning">
                        <label class="form-check-label" for="full_scanning">
                            Scanning
                        </label>
                    </div>
                </div>
            </div>
        <!--end-->

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
                <option value="24">2 years</option>
                <option value="36">3 years</option>
                <option value="48">4 years</option>
                <option value="60">5 years</option>
            </select>
            <br>
        </div>

        <input type="hidden" value="{{$vehicle['vehicleID']}}" name="vehicleID">
        <input type="hidden" value="{{ $vehicle['milage'] }}" name="milage">

        <button class="btn btn-dark" type="">Submit</button>
    </form>
</div>

<script>
    let maintenance_type = document.getElementById('maintenance_type');
    let oil_type_select = document.getElementById('oil_type');
    let mileage_interval_input = document.getElementById('mileage_interval');
    let basic_pms_services_container = document.getElementById('basic_pms_services');
    let full_pms_services_container = document.getElementById('full_pms_services');
    basic_pms_services_container.style.display = "none";
    full_pms_services_container.style.display = "none";

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

        if(maintenance_type.value === "Basic PMS"){
            basic_pms_services_container.style.display = "block";
            full_pms_services_container.style.display = "none";
        } else if(maintenance_type.value === "Full PMS"){
            basic_pms_services_container.style.display = "none";
            full_pms_services_container.style.display = "flex";
        } else {
            basic_pms_services_container.style.display = "none";
            full_pms_services_container.style.display = "none";
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