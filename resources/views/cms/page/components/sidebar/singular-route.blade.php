@if($panelRoute->isVisible())
    <li class="nav-item">
        <a href="{{ route($panelRoute->getRoute()) }}"
           @class(['nav-link','active' => $panelRoute->isActive()]) aria-current="page">
            @if($panelRoute->getIcon())
                {!! $panelRoute->getIcon()->render("me-2") !!}
            @endif
            {{ $panelRoute->getName() }}
        </a>
    </li>
@endif
