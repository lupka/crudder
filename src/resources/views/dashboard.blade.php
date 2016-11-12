@extends('crudder::layouts.main')

@section('content')

    <div class="row">

        @foreach($models as $model)

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                      {{ $model->getConfig('name_plural') }}
                      <a href="{{ $model->createUrl() }}" class="btn btn-sm btn-secondary pull-xs-right">New {{ $model->getConfig('name') }}</a>
                    </div>
                    <div class="card-block">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($model->dashboardItems() as $item)
                                    <tr>
                                        <td>{{ $item->{$model->getConfig('dashboard_name_field')} }}</td>
                                        <td>{{ $item->id }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        <a href="#" class="btn btn-sm btn-secondary pull-xs-right">Manage &raquo;</a>
                    </div>
                </div>
            </div>

        @endforeach

    </div>

@endsection
