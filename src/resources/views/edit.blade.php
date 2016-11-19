@extends('crudder::layouts.main')

@section('content')

    <h1>Edit {{ $crudderModel->getConfig('name') }}</h1>

    <form method="post">

        {{ csrf_field() }}

        @foreach($crudderModel->fields as $field)

            {!! $field->renderFormField($object) !!}

        @endforeach

        <button type="submit" class="btn btn-primary">Submit</button>

    </form>

@endsection

@section('footer_scripts')

    @foreach($crudderModel->scripts as $script)

        {!! $script !!}

    @endforeach

@endsection
