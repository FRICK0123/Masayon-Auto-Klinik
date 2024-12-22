<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Inbox</title>
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
            <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#admin_mobile_canvas">
                <img src="{{ asset('icons/list.svg') }}" alt="Sidebar">
            </button>
            <x-admin-dashboard.mobile-canvas/>

            <div class="container">
                <div class="d-flex justify-content-between align-items-center pb-2 bg-white p-2 rounded-3 shadow-sm border mt-4 mt-lg-0">
                    <h5 class="pt-2">INBOX</h5>
                </div>

                <div id="carTableContainer" class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Sender</th>
                            <th>Date Sent</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>

                        @foreach ($inboxes as $inbox)
                            <tr>
                                <td>{{ $inbox['fullname'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($inbox['created_at'])->format('F j, Y') }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm rounded-pill">
                                        View
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-dark btn-sm rounded-pill"
                                    data-bs-toggle="modal"
                                    data-bs-target="#replyInboxModal"
                                    data-fullname="{{ $inbox['fullname'] }}"
                                    data-email="{{ $inbox['email'] }}"
                                    data-message="{{ $inbox['message'] }}"
                                    data-inboxID="{{ $inbox['inboxID'] }}"
                                    onclick="replyModal(this)">
                                        Reply
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm rounded-pill">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

        </x-admin-dashboard.admin-content>
    </main>
    <!--End-->

    <!-- Reply Inbox Modal -->
    <div class="modal fade" id="replyInboxModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Reply to <span id="user"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('send_reply') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="client_message" class="form-label">Message:</label>
                        <textarea class="form-control border border-dark" id="client_message" rows="3" readonly></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="admin_message" class="form-label">Reply:</label>
                        <textarea class="form-control border border-dark" name="message" rows="3" required></textarea>
                    </div>

                    <input type="hidden" name="fullname" id="fullname_input">
                    <input type="hidden" name="email" id="email_input">
                    <input type="hidden" name="inboxID" id="inboxID">

                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark">Send</button>
                </form>
            </div>
            </div>
        </div>
    </div>

    <!-- Reply Sent Toast -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="replySentToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success">
                <strong class="me-auto text-light">Masayon Auto Klinik</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('sent') }}
            </div>
        </div>
    </div>

    <script>
        function replyModal(element){
            const fullname = element.getAttribute('data-fullname');
            const email = element.getAttribute('data-email');
            const message = element.getAttribute('data-message');
            const inboxID = element.getAttribute('data-inboxID');

            document.getElementById('client_message').value = message;
            document.getElementById('user').innerHTML = fullname;
            document.getElementById('email_input').value = email;
            document.getElementById('fullname_input').value = fullname;
            document.getElementById('inboxID').value = inboxID;

        }

        // Check if there's a vehicle deleted message in session
        @if (session('sent'))
            // Show the toast
            var toastEl = new bootstrap.Toast(document.getElementById('replySentToast'));
            toastEl.show();
        @endif
    </script>
</body>

</html>