<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{asset('css/admin_dashboard.css')}}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    <!--Bootstrap CDN Links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
            <div class="container">
                <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm">
                    <h5 class="pt-2">NOTIFICATIONS</h5>
                </div>

                <div id="carTableContainer">
                    <table class="table">
                        <tr>
                            <th>Reciever</th>
                            <th>Vehicle</th>
                            <th>Maintenance Type</th>
                            <th>Confirmation Status</th>
                            <th>Notification Date</th>
                            <th></th>
                        </tr>

                        @foreach ($notifications as $notification)
                            <tr>
                                <td>{{ $notification['owner'] }}</td>
                                <td>{{ $notification['vehicle'] }}</td>
                                <td>{{ $notification['maintenance_type'] }}</td>
                                <td>
                                    @if ($notification['isConfirmed'] == false)
                                        <div class="badge bg-danger">Not Confirmed</div>
                                    @else
                                        <div class="badge bg-success">Confirmed</div>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($notification['created_at'])->format('F j, Y') }}</td>
                                <td>
                                    <button class="btn btn-dark btn-sm rounded-pill"
                                    data-bs-toggle="modal"
                                    data-bs-target="#notificationModal"
                                    data-owner="{{ $notification['owner'] }}"
                                    data-vehicle="{{ $notification['vehicle'] }}"
                                    data-maintenance-type="{{ $notification['maintenance_type'] }}"
                                    data-scheduled-date="{{ \Carbon\Carbon::parse($notification['scheduled_date'])->format('F j, Y') }}"
                                    data-content="{{ $notification['content'] }}"
                                    data-notification-date="{{ \Carbon\Carbon::parse($notification['created_at'])->format('F j, Y') }}"
                                    onclick="viewNotif(this)">View</button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <!-- View Notification Modal -->
            <div class="modal fade" id="notificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Customer Notification</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Reciever: </strong><span id="owner"></span></p>
                    <p><strong>Vehicle: </strong><span id="vehicle"></span></p>
                    <p><strong>Maintenance Type: </strong><span id="maintenance_type"></span></p>
                    <p><strong>Scheduled Date: </strong><span id="scheduled_date"></span></p>
                    <p><strong>Notification Content: </strong><span id="content"></span></p>
                    <p><strong>Date Notified: </strong><span id="notification_date"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
            </div>
        </x-admin-dashboard.admin-content>
    </main>
    <!--End-->

    <script>
        function viewNotif(element){
            const owner = element.getAttribute('data-owner');
            const vehicle = element.getAttribute('data-vehicle');
            const maintenance_type = element.getAttribute('data-maintenance-type');
            const scheduled_date = element.getAttribute('data-scheduled-date');
            const content = element.getAttribute('data-content');
            const notification_date = element.getAttribute('data-notification-date');

            document.getElementById('owner').innerHTML = owner;
            document.getElementById('vehicle').innerHTML = vehicle;
            document.getElementById('maintenance_type').innerHTML = maintenance_type;
            document.getElementById('scheduled_date').innerHTML = scheduled_date;
            document.getElementById('content').innerHTML = content;
            document.getElementById('notification_date').innerHTML = notification_date;
        }
    </script>
</body>

</html>