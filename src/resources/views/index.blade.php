@extends('crudder::layouts.main')

@section('content')

    <h1>{{ $crudderModel->getConfig('name_plural') }}</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ $crudderModel->dashboardListingField()->getConfig('label') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $model)
                <tr>
                    <td>{{ $model->id }}</td>
                    <td>{{ $model->{$crudderModel->dashboardListingField()->fieldName} }}</td>
                    <td>
                        @include('crudder::partials.model_table_actions')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
