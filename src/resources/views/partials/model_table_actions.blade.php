@if($crudderModel->actionEnabled('update'))
    <a href="{{ $crudderModel->editUrl($model) }}">Edit</a>
@endif
@if($crudderModel->actionEnabled('delete'))
    <a href="{{ $crudderModel->deleteUrl($model) }}">Delete</a>
@endif
