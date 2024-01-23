<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PookieBoard CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ URL::asset("bundles/PookieBoardCMS/css/cms/base.css") }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/80e5202672.js" crossorigin="anonymous"></script>
</head>
<body data-bs-theme="dark">
<main>
    @include("cms.page.components.sidebar")
    <div class="pb-wrapper w-100">
        @include("cms.page.components.navbar")
        <div class="container-fluid mt-3 mb-5 h-100 pb-5 overflow-y-auto">
            @foreach (['danger', 'warning', 'success', 'info'] as $alertType)
                @if(request()->session()->has("cms.alert." . $alertType))
                    <div class="alert alert-{{ $alertType }}">
                        {{ request()->session()->get("cms.alert." . $alertType) }}
                    </div>
                @endif
            @endforeach
            @yield('content')
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
