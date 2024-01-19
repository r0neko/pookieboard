<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PookieBoard CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/base.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/80e5202672.js" crossorigin="anonymous"></script>
</head>
<body data-bs-theme="dark">
<main>
    @include("cms.page.components.sidebar")
    <div class="pb-wrapper w-100">
        @include("cms.page.components.navbar")
        <div class="container-fluid mt-1 h-100 overflow-y-scroll">
            @yield('content')
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
