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
                                <td><button class="btn btn-dark btn-sm rounded-pill">View</button></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </x-admin-dashboard.admin-content>
    </main>
    <!--End-->
</body>

</html>