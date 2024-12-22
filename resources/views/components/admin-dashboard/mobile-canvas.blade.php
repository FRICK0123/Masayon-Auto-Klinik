<div class="offcanvas offcanvas-start" tabindex="-1" id="admin_mobile_canvas">
  <div class="offcanvas-header">
        <div class="d-flex align-items-center">
            <img src="{{ asset('Images/'.Session::get('admin_logo')) }}" alt="Masayon Auto Klinik Logo" width="100">
            <div class="ms-3">
                <h4 class="m-0 p-0">{{ Session::get('username') }}</h4>
                <small class="m-0 p-0 text-success"><img src="{{ asset('icons/online_dot.png') }}" alt="Online" width="15">online</small>
            </div>
        </div>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="list-unstyled">
      <!-- Dashboard -->
      <li>
        <a href="{{ route('admin_dashboard') }}" class="d-block py-2">Dashboard</a>
      </li>

      <!-- User Management Dropdown -->
      <li class="dropdown">
        <a href="#" class="d-block py-2 dropdown-toggle" id="userManagementDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          User Management
        </a>
        <ul class="dropdown-menu" aria-labelledby="userManagementDropdown">
          <li><a class="dropdown-item" href="{{ route('users_view') }}">Customers</a></li>
          <li><a class="dropdown-item" href="{{ route('managers_view') }}">Managers</a></li>
        </ul>
      </li>

      <!-- Cars -->
      <li>
        <a href="{{ route('admin_cars') }}" class="d-block py-2">Cars</a>
      </li>

      <!-- Appointments -->
      <li>
        <a href="{{ route('admin_appointment_view') }}" class="d-block py-2">Appointments</a>
      </li>

      <!-- Maintenance Dropdown -->
      <li class="dropdown">
        <a href="#" class="d-block py-2 dropdown-toggle" id="maintenanceDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          Maintenance
        </a>
        <ul class="dropdown-menu" aria-labelledby="maintenanceDropdown">
          <li><a class="dropdown-item" href="{{ route('maintenance_overview') }}">Maintenance Overview</a></li>
          <li><a class="dropdown-item" href="{{ route('maintenance_status_view') }}">Maintenance Status</a></li>
        </ul>
      </li>

      <!-- Reports Dropdown -->
      <li class="dropdown">
        <a href="#" class="d-block py-2 dropdown-toggle" id="reportsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          Reports
        </a>
        <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
          <li><a class="dropdown-item" href="{{ route('reports_view') }}">Transactions</a></li>
          <li><a class="dropdown-item" href="{{ route('customer_reports_view') }}">Customer Registrations</a></li>
          <li><a class="dropdown-item" href="{{ route('customer_vehicles_view') }}">Customer Vehicles</a></li>
        </ul>
      </li>

      <!-- Notifications -->
      <li>
        <a href="{{ route('notification_view') }}" class="d-block py-2">Notifications</a>
      </li>

      <!-- Inbox -->
      <li>
        <a href="{{ route('inbox_view') }}" class="d-block py-2">Inbox</a>
      </li>
    </ul>
  </div>
</div>
