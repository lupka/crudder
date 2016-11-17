@extends('crudder::layouts.main')

@section('content')

    <h1>{{ $crudderModel->getConfig('name_plural') }}</h1>

    <table class="table">
        <thead>
            <tr>
                @foreach($crudderModel->indexDisplayFields() as $field)
                    <th>{{ $field->getConfig('label') }}</th>
                @endforeach
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $model)
                <tr>
                    @foreach($crudderModel->indexDisplayFields() as $field)
                        <td>{{ $model->{$field->fieldName} }}</td>
                    @endforeach
                    <td>
                        @include('crudder::partials.model_table_actions')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
