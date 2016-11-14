@extends('crudder::layouts.main')

@section('content')

    <h1>{{ $crudderModel->getConfig('name') }}</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->{$crudderModel->getConfig('dashboard_name_field')} }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
