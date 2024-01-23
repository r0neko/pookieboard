@if($item->isVisible())
    <li class="nav-item">
        <a @class(['nav-link', 'active' => $item->isActive()]) data-bs-toggle="collapse"
           data-bs-target="#{{ $item->getFriendlyName() }}-collapse" aria-expanded="true">
            @if($item->getIcon())
                {!! $item->getIcon()->render("me-2") !!}
            @endif
            {{ $item->getName() }}
        </a>
        <div @class(['collapse','show' => $item->isActive()]) id="{{ $item->getFriendlyName() }}-collapse">
            <ul class="nav-item-toggle list-unstyled fw-normal pb-1 small">
                @foreach($item->getItems() as $i)
                    @if($i->isVisible())
                        <li>
                            <a href="{{ route($i->getRoute()) }}" @class(['nav-link', 'active' => $i->isActive()])>
                                @if($item->getIcon())
                                    {!! $item->getIcon()->render("me-2") !!}
                                @endif
                                {{ $item->getName() }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </li>
@endif
