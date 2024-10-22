@props(['customers','interval'])
<div class="container">
    <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm">
        <h5 class="pt-2">CUSTOMER REPORTS</h5>
        
        <form action="#" method="GET" class="search-box">
            @csrf
            {{-- <input type="text" class="form-control rounded-5" placeholder="Search Customers" name="search_customers" autocomplete="off"> --}}
            <button class="btn-search" type="button"><img src="{{ asset('icons/magnifying-glass-white.svg') }}" alt="Search Customer" width="30"></button>
            <input type="text" class="input-search" placeholder="Search Customer">
        </form>
    </div>
    <div class="container pb-3">
        <div class="container-fluid mt-2">
            <h3>Customer Registration ({{ $interval }})</h3><br>

            @php
                $customers_count = $customers->count();
            @endphp

            <div class="d-flex justify-content-between">
                <h4>Transactions: {{ $customers_count }}</h4>

               <form method="GET" action="{{route('customer_reports_filter')}}">
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

                <button class="btn btn-success">Export PDF</button>
            </div>

            <!--Transactions table-->
            <div id="carTableContainer" class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th>FULLNAME</th>
                        <th>EMAIL</th>
                        <th>PHONE NUMBER</th>
                        <th>USERNAME</th>
                        <th>DATE REGISTERED</th>
                        <th></th>
                    </tr>

                    @foreach ($customers as $item)
                        <tr>
                            <td>{{ $item['fullname'] }}</td>
                            <td>{{ $item['email'] }}</td>
                            <td>{{ $item['phone_number'] }}</td>
                            <td>{{ $item['username'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($item['created_at'])->format('F j, Y') }}</td>
                            <td>
                                <button class="btn btn-dark">View</button>
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