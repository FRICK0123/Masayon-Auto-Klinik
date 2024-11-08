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
                    <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm mt-5 mt-lg-0">
                        <h5 class="pt-2">REPORTS</h5>

                        <form action="#" method="GET" class="search-box me-2">
                            @csrf
                            {{-- <input type="text" class="form-control rounded-5" placeholder="Search Customers" name="search_customers" autocomplete="off"> --}}
                            <button class="btn-search" type="button"><img src="{{ asset('icons/magnifying-glass-white.svg') }}" alt="Search Customer" width="30"></button>
                            <input type="text" class="input-search" placeholder="Search Report">
                        </form>
                    </div>
                </div>

                <div class="container">
                    <div class="container-fluid mt-2">
                        <a href="#" class="btn btn-danger btn-sm rounded-pill">Transactions</a>
                        <a href="{{ route('manager_customer_reports_view') }}" class="btn border border-dark btn-sm rounded-pill">Customer Registrations</a>
                        <h4>Repair/Maintenance Transactions ({{ $interval }})</h4><br>

                        @php
                            $transaction_count = $transaction->count();
                        @endphp

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold">Total Transactions: {{ $transaction_count }}</h5>
                            <form method="GET" action="{{ route('manager_reports_transaction') }}" class="d-flex align-items-center">
                                <label for="interval" class="me-2">Filter by:</label>
                                <select name="interval" id="interval" class="form-select rounded-pill" onchange="this.form.submit()">
                                    <option value="daily" {{ $interval == 'daily' ? 'selected' : '' }}>This Day</option>
                                    <option value="weekly" {{ $interval == 'weekly' ? 'selected' : '' }}>This Week</option>
                                    <option value="monthly" {{ $interval == 'monthly' ? 'selected' : '' }}>This Month</option>
                                    <option value="yearly" {{ $interval == 'yearly' ? 'selected' : '' }}>This Year</option>
                                </select>
                            </form>
                        </div>

                        <div class="mb-2">
                            <form action="{{ route('reports_by_date_range') }}" method="GET" class="d-flex flex-column flex-md-row">
                                <label for="start_date" class="me-2">Start Date:</label>
                                <input type="date" class="me-2" name="start_date" required>

                                <label for="end_date" class="me-2">End Date:</label>
                                <input type="date" class="me-2" name="end_date" required>

                                <button class="btn btn-dark">Filter</button>
                            </form>
                        </div>

                    <!-- Cards for Transaction Data -->
                    <div class="row mt-4">
                        @foreach ($transaction as $item)
                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">Vehicle: {{ $item['vehicle'] }}</h5>
                                        <p class="card-text">Owner: {{ $item['owner'] }}</p>
                                        <p class="card-text">Maintenance Type: {{ $item['maintenance_type'] }}</p>
                                        <p class="card-text">Date Performed: {{ $item['date_performed'] }}</p>
                                        <!-- Add more fields as necessary -->
                                        <a href="#" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $transaction->appends(['interval' => $interval])->links() }}
                    </div>
                    
                    {{-- <h4>Customer Registration ({{ $interval }})</h4><br>

                    <!-- Cards for Customers Data -->
                    <div class="row mt-4">
                        @foreach ($customers as $item)
                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">Fullname: {{ $item['fullname'] }}</h5>
                                        <p class="card-text">Email: {{ $item['email'] }}</p>
                                        <p class="card-text">Phone Number: {{ $item['phone_number'] }}</p>
                                        <p class="card-text">Date Registered: {{ $item['created_at'] }}</p>
                                        <!-- Add more fields as necessary -->
                                        <a href="#" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $customers->appends(['interval' => $interval])->links() }}
                    </div> --}}
                </div>
            </x-manager-dashboard.manager-content>
        </main>
    <!--End-->
</body>
</html>