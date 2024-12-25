<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Reports</title>
    <link rel="stylesheet" href="{{asset('css/admin_dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('css/table_style.css')}}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    <!--Bootstrap CDN Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!--Preloader-->
        <x-preloader/>
    <!--End-->
    <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Do you want to log out?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger">Log out</button>
                </form>
            </div>
            </div>
        </div>
        </div>
    <!--end-->

    <!--Header-->
        <header style="position: fixed; width: 100%; z-index: 100;">
            <x-admin-dashboard.header/>
        </header>
    <!--Header end-->

    <!--Main Content-->
    <main>
        <x-admin-dashboard.admin-content>
            <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#admin_mobile_canvas">
                <img src="{{ asset('icons/list.svg') }}" alt="Sidebar">
            </button>
            <x-admin-dashboard.mobile-canvas/>

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
                            $customers_count = $customers->total();
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

                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center">
                            {{ $customers->appends(request()->query())->links() }}
                        </div>
                        <!--End-->
                    </div>
                </div>
            </div>
        </x-admin-dashboard.admin-content>
    </main>
    <!--End-->

    <script>
        function exportCustomerPdf(){
            document.getElementById('export_customer_pdf').submit();
        }

        function exportCustomerExcel(){
            document.getElementById('export_customer_excel').submit();
        }
    </script>
</body>

</html>