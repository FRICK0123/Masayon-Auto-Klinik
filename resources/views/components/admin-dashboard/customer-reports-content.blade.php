@props(['customers','interval'])
<div class="container">
    <div class="d-flex justify-content-between align-items-center pb-3 bg-white p-3 rounded-3 shadow-sm mb-4">
        <h4 class="pt-2 fw-bold">CUSTOMER REPORTS</h4>

        <div class="d-flex align-items-center">
            <form action="#" method="GET" class="search-box me-2">
                @csrf
                {{-- <input type="text" class="form-control rounded-5" placeholder="Search Customers" name="search_customers" autocomplete="off"> --}}
                <button class="btn-search" type="button"><img src="{{ asset('icons/magnifying-glass-white.svg') }}" alt="Search Customer" width="30"></button>
                <input type="text" class="input-search" placeholder="Search Customer">
            </form>
            <form action="{{ route('export.customer_pdf') }}" method="GET">
                @csrf
                <!-- Include selected filters as hidden inputs -->
                <input type="hidden" name="interval" value="{{ $interval }}">
                <input type="hidden" name="start_date" value="{{ request()->input('start_date') }}">
                <input type="hidden" name="end_date" value="{{ request()->input('end_date') }}">
                
                <button type="submit" class="btn btn-success rounded-pill">Export PDF</button>
            </form>
        </div>
    </div>

    <div class="container pb-3">
        <div class="container-fluid mt-2">
            <h3>Customer Registration ({{ $interval }})</h3><br>

            @php
                $customers_count = $customers->count();
            @endphp

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Customer Registrations: {{ $customers_count }}</h5>

               <form method="GET" action="{{route('customer_reports_filter')}}" class="d-flex align-items-center">
                    <label for="interval">Select Interval:</label>
                    <select name="interval" id="interval" onchange="this.form.submit()" class="form-select rounded-pill">
                            <option value="daily" {{ $interval == 'daily' ? 'selected' : '' }}>This Day</option>
                            <option value="weekly" {{ $interval == 'weekly' ? 'selected' : '' }}>This Week</option>
                            <option value="monthly" {{ $interval == 'monthly' ? 'selected' : '' }}>This Month</option>
                            <option value="yearly" {{ $interval == 'yearly' ? 'selected' : '' }}>This Year</option>
                    </select>
                </form>
            </div>

            <div class="mb-3">
                <form action="{{ route('customer_reports_date_range') }}" method="GET" class="d-flex flex-column flex-md-row align-items-center gap-2">
                    <label for="start_date" class="me-2">Start Date:</label>
                    <input type="date" class="me-2" name="start_date" required>

                    <label for="end_date" class="me-2">End Date:</label>
                    <input type="date" class="me-2" name="end_date" required>

                    <button class="btn btn-dark">Filter</button>
                </form>
            </div>

            <!--Transactions table-->
            <div id="carTableContainer" class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>USERS</th>
                                <th>CONTACT #</th>
                                <th>USERNAME</th>
                                <th>STATUS</th>
                                <th>DATE REGISTERED</th>
                                <th></th>
                            </tr>
                            @foreach ($customers as $user)
                                <tr>
                                    <td class="d-flex">
                                        @php
                                            $lastSeen = \Carbon\Carbon::parse($user['last_seen']);
                                            $isOnline = $lastSeen->diffInMinutes(now()) <= 3; // Check if last seen is within 3 minutes
                                        @endphp

                                        @if ($isOnline)
                                            <small><img src="{{ asset('icons/online_dot.png') }}" alt="Online" width="15"></small>
                                        @else
                                            <small><img src="{{ asset('icons/offline_dot.png') }}" alt="Online" width="10"></small>
                                        @endif
                                        
                                        <img src="{{ asset('Images/profile_images/'.$user['profile_img']) }}" alt="Profile Icon" width="50" height="50" style="object-fit: cover; border-radius: 50%;">
                                        <div class="d-flex flex-column ms-3">
                                            <span>{{ $user['fullname'] }}</span>
                                            <span style="font-size: 13px">{{ $user['email'] }}</span>
                                        </div>
                                    </td>
                                    <td>0{{ $user['phone_number'] }}</td>
                                    <td>{{ $user['username'] }}</td>
                                    @if ($user['isDeactivated'] == true)
                                        <td><span class="badge bg-danger p-2">Deactivated</span></td>
                                    @elseif($user['isDeactivated'] == false && $user['isVerified'] == true)
                                        <td><span class="badge bg-success p-2">Verified</span></td>
                                    @else
                                        <td>Not Verified</td>
                                    @endif
                                    <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('F j, Y') }}</td>

                                    <td>
                                        <div class="dropdown" style="position: static;">
                                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('view_user_info',$user['customerID']) }}">View</a></li>

                                                <li><a class="dropdown-item" href="{{ route('add_vehicle_view',$user['customerID']) }}">Add Vehicle</a></li>

                                                <li><a class="dropdown-item" href="{{ route('view_user_vehicle_info', $user['customerID']) }}">Add Maintenance Schedule</a></li>

                                                <li><a class="dropdown-item" href="{{ route('edit_user_info_view',$user['customerID']) }}">Edit</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
            </div>
            <!--End-->
        </div>
    </div>
</div>

{{-- <!--View Transaction-->
<div class="modal fade" id="view_transaction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
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
</div> --}}

{{-- <script>
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
</script> --}}