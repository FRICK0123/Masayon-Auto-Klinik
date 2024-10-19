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