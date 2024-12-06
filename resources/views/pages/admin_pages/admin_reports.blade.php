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

    <!-- Add Chart.js CDN -->
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
                    <h4 class="pt-2 fw-bold">REPORTS</h4>

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
                                <li onclick="exportPdf()" style="cursor: pointer;">
                                    <form action="{{ route('export.transaction.pdf') }}" method="GET" class="dropdown-item" id="export_pdf">
                                        @csrf
                                        <p>Export PDF</p>

                                        <!-- Include selected filters as hidden inputs -->
                                        <input type="hidden" name="interval" value="{{ $interval }}">
                                        <input type="hidden" name="start_date" value="{{ request()->input('start_date') }}">
                                        <input type="hidden" name="end_date" value="{{ request()->input('end_date') }}">                        
                                    </form>
                                </li>
                                <li style="cursor: pointer;" onclick="exportExcel()">
                                    <form action="{{ route('export_transaction_excel') }}" method="GET" class="dropdown-item" id="export_excel">
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
                        <h4>Repair/Maintenance Transactions ({{ $interval }})</h4><br>

                        @php
                            $transaction_count = $transactions->count();
                        @endphp

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold">Total Transactions: {{ $transaction_count }}</h5>
                            <form method="GET" action="{{ route('reports_transaction_filter') }}" class="d-flex align-items-center">
                                <label for="interval" class="me-2">Filter by:</label>
                                <select name="interval" id="interval" class="form-select rounded-pill" onchange="this.form.submit()">
                                    <option value="daily" {{ $interval == 'daily' ? 'selected' : '' }}>This Day</option>
                                    <option value="weekly" {{ $interval == 'weekly' ? 'selected' : '' }}>This Week</option>
                                    <option value="monthly" {{ $interval == 'monthly' ? 'selected' : '' }}>This Month</option>
                                    <option value="yearly" {{ $interval == 'yearly' ? 'selected' : '' }}>This Year</option>
                                </select>
                            </form>
                        </div>

                        <div class="mb-3">
                            <form action="{{ route('reports_transaction_by_date_range') }}" method="GET" class="d-flex flex-column flex-md-row align-items-center gap-2">
                                <label for="start_date" class="me-2">Start Date:</label>
                                <input type="date" class="me-2" name="start_date" required>

                                <label for="end_date" class="me-2">End Date:</label>
                                <input type="date" class="me-2" name="end_date" required>

                                <button class="btn btn-dark">Filter</button>
                            </form>
                        </div>

                        <!--Transactions table-->
                        <div id="carTableContainer" class="table-responsive">
                            <table class="table table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>VEHICLE</th>
                                        <th>OWNER</th>
                                        <th>MAINTENANCE TYPE</th>
                                        <th>COST</th>
                                        <th>DATE PERFORMED</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $item)
                                        <tr>
                                            <td>{{ $item->vehicle }}</td>
                                            <td>{{ $item->owner }}</td>
                                            <td>{{ $item->maintenance_type }}</td>
                                            <td>₱{{ number_format($item->cost, 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->date_performed)->format('F j, Y') }}</td>
                                            <td>
                                                <button class="btn btn-dark btn-sm rounded-pill" 
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
                                                onclick="populateModal(this)">View</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--End-->

                        <div>
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!--View Transaction-->
            <div class="modal fade" id="view_transaction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header bg-dark text-white">
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
            </div>

        </x-admin-dashboard.admin-content>
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

        function exportPdf(){
            document.getElementById('export_pdf').submit();
        }

        function exportExcel(){
            document.getElementById('export_excel').submit();
        }

    var ctx = document.getElementById('monthlyChart').getContext('2d');
    var monthlyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($daysOfMonth), // Days of the month
            datasets: [{
                label: 'Transactions per Day',
                data: @json($transactionCounts), // Transaction counts per day
                borderColor: 'rgb(75, 192, 192)',
                fill: false,
                tension: 0.1
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'category',
                    title: {
                        display: true,
                        text: 'Days of ' + new Date().toLocaleString('default', { month: 'long' })
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Number of Transactions'
                    }
                }
            }
        }
    });
    </script>
</body>

</html>