<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="{{asset('css/manager_dashboard.css')}}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    <!--Bootstrap CDN Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body>
    <!--Preloader-->
    <x-preloader/>
    <!--End-->

    <!--Header-->
    <header>
        <x-manager-dashboard.header/>
    </header>
    <!--Header end-->

    <!--Main Content-->
    <main>
        <x-manager-dashboard.manager-content>
            <div class="container">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center pb-2 bg-white p-3 rounded-3 shadow-sm mt-5 mt-lg-0">
                    <h5 class="pt-2">REPORTS</h5>
                        <form action="{{ route('manager_customer_reports_view') }}" method="GET" class="search-box me-2">
                            @csrf
                            <button class="btn-search" type="button"><img src="{{ asset('icons/magnifying-glass-white.svg') }}" alt="Search Customer" width="30"></button>
                            <input type="text" class="input-search" placeholder="Search Customer" name="search_customer">
                        </form>
                </div>
            </div>

            <div class="container mt-3">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <a href="{{ route('manager_reports_view') }}" class="btn border border-dark btn-sm rounded-pill">Transactions</a>
                    <a href="#" class="btn btn-danger btn-sm rounded-pill">Customer Registrations</a>
                    <a href="{{ route('manager_customer_vehicles') }}" class="btn border border-dark btn-sm rounded-pill">Customer Vehicles</a>
                </div>
                <h4>Repair/Maintenance Transactions ({{ $interval }})</h4><br>

                @php
                    $transaction_count = $customers->count();
                @endphp

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
                    <h6 class="fw-bold">Total Customers: {{ $transaction_count }}</h6>
                    <form method="GET" action="{{ route('customer_filters') }}" class="d-flex align-items-center mt-2 mt-md-0">
                        <select name="interval" id="interval" class="form-select rounded-pill" onchange="this.form.submit()">
                            <option value="daily" {{ $interval == 'daily' ? 'selected' : '' }}>This Day</option>
                            <option value="weekly" {{ $interval == 'weekly' ? 'selected' : '' }}>This Week</option>
                            <option value="monthly" {{ $interval == 'monthly' ? 'selected' : '' }}>This Month</option>
                            <option value="yearly" {{ $interval == 'yearly' ? 'selected' : '' }}>This Year</option>
                        </select>
                    </form>
                </div>

                <div class="mb-3">
                    <form action="{{ route('customers_by_date_range') }}" method="GET" class="d-flex flex-column flex-md-row align-items-center gap-2">
                        <label for="start_date" class="form-label mb-0">Start Date:</label>
                        <input type="date" class="form-control me-2" name="start_date" required>

                        <label for="end_date" class="form-label mb-0">End Date:</label>
                        <input type="date" class="form-control me-2" name="end_date" required>

                        <button class="btn btn-dark">Filter</button>
                    </form>
                </div>

                <!-- Cards for Customers Data -->
                <div class="row mt-4">
                    @foreach ($customers as $item)
                        <div class="col-12 col-sm-6 col-lg-4 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">Fullname: {{ $item['fullname'] }}</h5>
                                    <p class="card-text">Email: {{ $item['email'] }}</p>
                                    <p class="card-text">Phone Number: {{ $item['phone_number'] }}</p>
                                    <p class="card-text">Date Registered: {{ \Carbon\Carbon::parse($item['created_at'])->format('F j, Y') }}</p>
                                    <a href="{{ route('manager_view_customer_info',$item['customerID']) }}" class="btn btn-dark mt-auto">View Customer</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Pagination Links -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $customers->appends(['interval' => $interval])->links() }}
                </div>
            </div>
        </x-manager-dashboard.manager-content>
    </main>
    <!--End-->
</body>
</html>
