@extends('cms.page.base')

@section('heading', "Model Overview")

@section('content')
    <a type="button" class="btn btn-primary" href="{{ route("cms.model.add", ["model" => $model]) }}">Add</a>
    <table class="table table-striped">
        <thead>
        <tr class="table-light">
            @foreach($columns as $col)
                <th scope="col">
                    @if(!str_starts_with($col, "#"))
                        {{ $col }}
                    @endif
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($values as $val)
            <tr class="align-middle">
                @foreach($val as $v)
                    <td>{{ $v }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
