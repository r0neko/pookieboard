@if($item->isVisible())
    <li class="nav-item">
        <a href="{{ route($item->getRoute()) }}"
           @class(['nav-link','active' => $item->isActive()]) aria-current="page">
            @if($item->getIcon())
                {!! $item->getIcon()->render("me-2") !!}
            @endif
            {{ $item->getName() }}
        </a>
    </li>
@endif
