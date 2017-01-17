@extends('crudder::layouts.main')

@section('content')

    <h1>View {{ $crudderModel->getConfig('name') }}</h1>

    @foreach($crudderModel->fields as $field)

        <div>
            <strong>{{ $field->getConfig('label') }}</strong><br>
            {!! $field->displayValue($model) !!}
        </div>

    @endforeach

@endsection
