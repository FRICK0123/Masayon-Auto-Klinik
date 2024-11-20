<div class="container">
    <div class="text-center mb-4">
      <h2 class="fw-bold">Contact Us</h2>
      <p class="text-muted">Have questions and concerns? Contact Us: 09171462724</p>
    </div>
    <!-- Contact Form -->
    <form action="{{ route('contact.send') }}" method="POST" class="p-4 rounded shadow-sm bg-light">
        @csrf
        <div class="mb-3">
            <label for="fullname" class="form-label fw-bold">Full Name</label>
            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your full name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label fw-bold">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Type your message here" required></textarea>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-dark">Send Message</button>
        </div>
    </form>
</div>

<!-- Message Sent Toast Notification -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="contactToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success">
            <strong class="me-auto text-light">Masayon Auto Klinik</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('contact') }}
        </div>
    </div>
</div>

<script>
    @if (session('contact'))
        // Show the toast
        var toastEl = new bootstrap.Toast(document.getElementById('contactToast'));
        toastEl.show();
    @endif
</script>