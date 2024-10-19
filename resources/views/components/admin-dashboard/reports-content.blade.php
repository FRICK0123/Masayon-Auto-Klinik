@props(['transaction','interval'])
<div class="container">
    <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm">
        <h5 class="pt-2">REPORTS</h5>

        <button class="btn btn-success">Export PDF</button>
    </div>
    <div class="container pb-3">
        <div class="container-fluid mt-2">
            <h3>Repair/Maintenance Transactions ({{ $interval }})</h3><br>

            @php
                $transaction_count = $transaction->count();
            @endphp

            <div class="d-flex justify-content-between">
                <h4>Transactions: {{ $transaction_count }}</h4>

               <form method="GET" action="{{route('reports_transaction_filter')}}">
                    <label for="interval">Select Interval:</label>
                    <select name="interval" id="interval" onchange="this.form.submit()">
                            <option value="daily" {{ $interval == 'daily' ? 'selected' : '' }}>This Day</option>
                            <option value="weekly" {{ $interval == 'weekly' ? 'selected' : '' }}>This Week</option>
                            <option value="monthly" {{ $interval == 'monthly' ? 'selected' : '' }}>This Month</option>
                            <option value="yearly" {{ $interval == 'yearly' ? 'selected' : '' }}>This Year</option>
                    </select>
                </form>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <form action="{{ route('reports_transaction_by_date') }}" method="GET" class="d-flex">
                    <input type="date" class="form-control" name="selected_date">
                    <button class="btn btn-dark">Submit</button>
                </form>

                <form action="#" method="GET">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="search_customers" autocomplete="off">
                        <button class="btn btn-dark">Search</button>
                    </div>
                </form>
            </div>

            <!--Transactions table-->
            <div id="carTableContainer" class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th>VEHICLE</th>
                        <th>OWNER</th>
                        <th>MAINTENANCE TYPE</th>
                        <th>COST</th>
                        <th>DATE PERFORMED</th>
                        <th></th>
                    </tr>

                    @foreach ($transaction as $item)
                        <tr>
                            <td>{{ $item->vehicle }}</td>
                            <td>{{ $item->owner }}</td>
                            <td>{{ $item->maintenance_type }}</td>
                            <td>₱{{ $item->cost }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->date_performed)->format('F j, Y') }}</td>
                            <td>
                                <button class="btn btn-dark" 
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

        <label class="fw-bold">Oil Type:</label>
        <p id="oil_type"></p>

        <label class="fw-bold">PMS Services:</label>
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
        document.getElementById('oil_type').innerHTML = oil_type;
        document.getElementById('pms_services').innerHTML = pms_services;
        document.getElementById('cost').innerHTML = `₱ ${cost}`;
        document.getElementById('date_performed').innerHTML = date_performed;
        document.getElementById('maintenance_description').innerHTML = maintenance_description;
    }
</script>