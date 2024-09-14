@props(['users'])
<div class="container">
    <h2 class="pb-2 border-bottom">USER MANAGEMENT</h2>

    <!--Functionalities-->
        <div class="d-flex justify-content-between">
            <form action="#" method="GET" class="me-2">
                <button class="btn btn-dark"><small>+ New User</small></button>
            </form>

            <form action="#" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search users">
                    <button class="btn btn-dark" id="basic-addon2">Search</button>
                </div>
            </form>
        </div>
        <div>
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{asset('icons/funnel.svg')}}" alt="Filter">
                </button>
                <form id="carFilterForm" action="#" method="GET" class="dropdown-menu p-2">
                    <input type="radio" id="by_fullname" name="filter_users" class="form-check-input border border-1 border-dark" value="by_fullname">
                    <label for="by_fullname" class="ms-2">By Fullname</label><br><br>

                    <input type="radio" id="by_username" name="filter_users" class="form-check-input border border-1 border-dark" value="by_username">
                    <label for="by_username" class="ms-2">By Username</label><br><br>

                    <input type="radio" id="by_creation" name="filter_users" class="form-check-input border border-1 border-dark" value="by_creation">
                    <label for="by_creation" class="ms-2">By Latest</label><br><br>

                    <button type="submit" class="btn btn-dark">Filter</button>
                </form>
            </div>
        </div>
    <!--end-->

    <!--User Management Table-->
        <table class="table table-striped table-responsive">
            <tr>
                <th>FULL NAME</th>
                <th>EMAIL</th>
                <th>CONTACT #</th>
                <th>USERNAME</th>
                <th>STATUS</th>
                <th></th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user['fullname'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>0{{ $user['phone_number'] }}</td>
                    <td>{{ $user['username'] }}</td>
                    @if ($user['isVerified'] == 1)
                        <td>verified</td>
                    @else
                        <td>not verified</td>
                    @endif
                    <td>
                        <div class="dropdown">
                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">...</button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">View</a></li>
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item bg-danger text-light" href="#">Deactivate</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    <!--End-->
</div>