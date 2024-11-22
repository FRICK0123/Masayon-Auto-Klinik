@props(['transaction','interval'])
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
            <form action="{{ route('export.transaction.pdf') }}" method="GET">
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
            <h4>Repair/Maintenance Transactions ({{ $interval }})</h4><br>

            @php
                $transaction_count = $transaction->count();
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
                        @foreach ($transaction as $item)
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