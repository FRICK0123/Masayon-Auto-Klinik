<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Message</title>
</head>
<body>
    <h1>New Contact Message</h1>
    <p><strong>Full Name:</strong> {{ $fullname }}</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Message:</strong></p>
    <p>{{ $message_content }}</p> <!-- Use the updated key name -->
</body>
</html>
