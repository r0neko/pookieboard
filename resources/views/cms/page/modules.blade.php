@extends('cms.page.base')

@section('heading', "Modules")

@section('content')
    <br>
    <div class="alert alert-danger"><b>IMPORTANT:</b>&nbsp;This page is currently WORK IN PROGRESS and features NO FUNCTIONALITY as of
        now.<br>Please use the equivalent console commands in order
        to manage the modules:
        <code>php artisan
            module:activate &lt;module&gt;</code> or <code>php artisan module:deactivate &lt;module&gt;</code>
    </div>
    @foreach($modules as $module)
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $module->getName() }}
                    @if(!$module->isActive())
                        &nbsp;
                        <small class="text-muted">(inactive)</small>
                    @endif
                </h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $module->getDescription() ?: 'No description provided.' }}</h6>

                <div class="mt-3">
                    @if(!$module->isActive())
                        <button type="button" class="btn btn-primary">Activate</button>
                    @else
                        <button type="button" class="btn btn-secondary">Deactivate</button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endsection
