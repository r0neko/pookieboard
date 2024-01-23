@php
    use App\PookieBoard\Modules\Navigation\NavigationItem;
    use App\PookieBoard\Modules\Navigation\NestedNavigationItemCollection;
@endphp

<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark pb-sidebar-container">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4">PookieBoard&nbsp;<small>({{ app('cms.version') }})</small></span>
    </a>
    <hr>
    <div class="offcanvas-md offcanvas-start h-100" tabindex="-1" id="pb-sidebar" aria-labelledby="pb-sidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="pb-sidebarLabel">PookieBoard</h5>
            <button type="button" class="btn-close text-reset" data-bs-target="#pb-sidebar" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column flex-shrink-1 text-white h-100">
            <ul class="nav nav-pills flex-column mb-auto">
                @foreach($cmsSidebarItems->getItems() as $item)
                    @if($item instanceof NavigationItem)
                        @include("cms.page.components.sidebar.singular-item", ["item" => $item])
                    @elseif($item instanceof NestedNavigationItemCollection)
                        @include("cms.page.components.sidebar.nested-item", ["item" => $item])
                    @endif
                @endforeach
            </ul>
            {{-- @include("cms.page.components.user-dropdown") --}}
        </div>
    </div>
</div>
