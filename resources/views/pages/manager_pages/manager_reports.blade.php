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

                        <form action="{{ route('manager_reports_view') }}" method="GET" class="search-box me-2">
                            @csrf
                            <button class="btn-search" type="button"><img src="{{ asset('icons/magnifying-glass-white.svg') }}" alt="Search Report" width="30"></button>
                            <input type="text" class="input-search" placeholder="Search Report" name="search_report">
                        </form>
                </div>
            </div>

            <div class="container mt-3">
                <div class="d-flex flex-wrap gap-2">
                    <a href="#" class="btn btn-danger btn-sm rounded-pill">Transactions</a>
                    <a href="{{ route('manager_customer_reports_view') }}" class="btn border border-dark btn-sm rounded-pill">Customer Registrations</a>
                    <a href="{{ route('manager_customer_vehicles') }}" class="btn border border-dark btn-sm rounded-pill">Customer Vehicles</a>
                </div>
                <h4 class="mt-3">Repair/Maintenance Transactions ({{ $interval }})</h4><br>

                @php
                    $transaction_count = $transaction->count();
                @endphp

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
                    <h6 class="fw-bold">Total Transactions: {{ $transaction_count }}</h6>
                    <form method="GET" action="{{ route('manager_reports_transaction') }}" class="d-flex align-items-center mt-2 mt-md-0">
                        <select name="interval" id="interval" class="form-select rounded-pill" onchange="this.form.submit()">
                            <option value="daily" {{ $interval == 'daily' ? 'selected' : '' }}>This Day</option>
                            <option value="weekly" {{ $interval == 'weekly' ? 'selected' : '' }}>This Week</option>
                            <option value="monthly" {{ $interval == 'monthly' ? 'selected' : '' }}>This Month</option>
                            <option value="yearly" {{ $interval == 'yearly' ? 'selected' : '' }}>This Year</option>
                        </select>
                    </form>
                </div>

                <div class="mb-3">
                    <form action="{{ route('reports_by_date_range') }}" method="GET" class="d-flex flex-column flex-md-row align-items-center gap-2">
                        <label for="start_date" class="form-label mb-0">Start Date:</label>
                        <input type="date" class="form-control me-2" name="start_date" required>

                        <label for="end_date" class="form-label mb-0">End Date:</label>
                        <input type="date" class="form-control me-2" name="end_date" required>

                        <button class="btn btn-dark">Filter</button>
                    </form>
                </div>

                <!-- Cards for Transaction Data -->
                <div class="row mt-4">
                    @foreach ($transaction as $item)
                        <div class="col-12 col-sm-6 col-lg-4 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">Vehicle: {{ $item['vehicle'] }}</h5>
                                    <p class="card-text">Owner: {{ $item['owner'] }}</p>
                                    <p class="card-text">Maintenance Type: {{ $item['maintenance_type'] }}</p>
                                    <p class="card-text">Date Performed: {{ \Carbon\Carbon::parse($item['date_performed'])->format('F j, Y') }}</p>
                                    <a href="#" class="btn btn-dark mt-auto"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#view_transaction"
                                    data-owner="{{ $item['owner'] }}"
                                    data-vehicle="{{ $item['vehicle'] }}"
                                    data-previous-milage="{{ $item['previous_milage'] }}"
                                    data-current-milage="{{ $item['current_milage'] }}"
                                    data-maintenance-type="{{ $item['maintenance_type'] }}"
                                    data-oil-type="{{ $item['oil_type'] }}"
                                    data-pms-services="{{ $item['pms_services'] }}"
                                    data-cost="{{ $item['cost'] }}"
                                    data-date-performed="{{ \Carbon\Carbon::parse($item->date_performed)->format('F j, Y') }}"
                                    data-maintenance-description="{{ $item['maintenance_description'] }}"
                                    onclick="populateModal(this)">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Pagination Links -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $transaction->appends(['interval' => $interval, 'search_report' => request()->input('search_report')])->links() }}
                </div>
            </div>
            <!--View Transaction-->
            <div class="modal fade" id="view_transaction" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h1 class="modal-title fs-5">Transaction Information</h1>
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
            </div>
        </x-manager-dashboard.manager-content>
    </main>
    <!--End-->

    <script>
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
    </script>
</body>
</html>
