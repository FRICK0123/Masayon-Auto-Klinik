@props(['histories'])

<div class="container">
    <h2 class="pb-2 border-bottom">MAINTENANCE HISTORY</h2>

    <!--Cars table-->
    <div id="carTableContainer">
        <table class="table table-striped table-responsive">
            <tr>
                <th>VEHICLE</th>
                <th>OWNER</th>
                <th>MAINTENANCE TYPE</th>
                <th>COST</th>
                <th>DATE PERFORMED</th>
                <th></th>
            </tr>

            @foreach ($histories as $history)
                <tr>
                    <td>{{ $history->vehicle }}</td>
                    <td>{{ $history->owner }}</td>
                    <td>{{ $history->maintenance_type }}</td>
                    <td>₱{{ $history->cost }}</td>
                    <td>{{ \Carbon\Carbon::parse($history->date_performed)->format('F j, Y') }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">View</a></li>
                                <li><a class="dropdown-item" href="#">Notify</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <!--End-->
</div>