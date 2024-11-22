<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webinar Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="container my-4">
            <h1>Webinar Management</h1>
            <nav class="nav">
                <a class="nav-link" href="{{ route('webinars.index') }}">Home</a>
            </nav>
        </div>
    </header>
    <main class="container">
        @yield('content')
    </main>
    <footer class="text-center my-4">
        <p>&copy; {{ date('Y') }} Webinar Management</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>