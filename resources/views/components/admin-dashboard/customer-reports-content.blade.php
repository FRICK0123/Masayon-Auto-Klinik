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

            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Export
                </button>
                <ul class="dropdown-menu">
                    <li onclick="exportCustomerPdf()" style="cursor: pointer;">
                        <form action="{{ route('export.customer_pdf') }}" method="GET" class="dropdown-item" id="export_customer_pdf">
                            @csrf
                            <p>Export PDF</p>

                            <!-- Include selected filters as hidden inputs -->
                            <input type="hidden" name="interval" value="{{ $interval }}">
                            <input type="hidden" name="start_date" value="{{ request()->input('start_date') }}">
                            <input type="hidden" name="end_date" value="{{ request()->input('end_date') }}">                        
                        </form>
                    </li>
                    <li style="cursor: pointer;" onclick="exportCustomerExcel()">
                        <form action="{{ route('export_customer_excel') }}" method="GET" class="dropdown-item" id="export_customer_excel">
                            @csrf
                            <p>Export Excel</p>                      
                        </form>
                    </li>
                </ul>
            </div>
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

<script>
    function exportCustomerPdf(){
        document.getElementById('export_customer_pdf').submit();
    }

    function exportCustomerExcel(){
        document.getElementById('export_customer_excel').submit();
    }
</script>