@extends('crudder::layouts.main')

@section('content')

    <div class="row">

        @foreach($crudderModels as $crudderModel)

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                      {{ $crudderModel->getConfig('name_plural') }}
                      <a href="{{ $crudderModel->createUrl() }}" class="btn btn-sm btn-secondary pull-xs-right">New {{ $crudderModel->getConfig('name') }}</a>
                    </div>
                    <div class="card-block">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ $crudderModel->dashboardListingField()->getConfig('label') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($crudderModel->dashboardItems() as $model)
                                    <tr>
                                        <td>{!! $crudderModel->dashboardListingField()->displayValue($model) !!}</td>
                                        <td>@include('crudder::partials.model_table_actions')</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        <a href="{{ $crudderModel->indexUrl() }}" class="btn btn-sm btn-secondary pull-xs-right">Manage &raquo;</a>
                    </div>
                </div>
            </div>

        @endforeach

    </div>

@endsection
