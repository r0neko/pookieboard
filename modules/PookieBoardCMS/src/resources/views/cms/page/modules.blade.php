@extends('cms.page.base')

@section('heading', "Modules")

@section('content')
    @foreach($modules as $module)
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $module->getName() }}
                    <small class="text-muted">(v{{ $module->version() }})</small>
                    @if(!$module->isActive())
                        <small class="text-muted">(inactive)</small>
                    @endif
                </h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $module->getDescription() ?: 'No description provided.' }}</h6>

                @if(!$module->isCoreModule())
                    <div class="mt-3">
                        @if(!$module->isActive())
                            <a href="{{ route("cms.module.activate", ["module" => $module->getName()]) }}" class="btn btn-primary">Activate</a>
                        @else
                            <a href="{{ route("cms.module.deactivate", ["module" => $module->getName()]) }}" class="btn btn-secondary">Deactivate</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endforeach
@endsection
