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
                        <a href="{{ $crudderModel->editUrl($model) }}">Edit</a>
                        <a href="{{ $crudderModel->deleteUrl($model) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
