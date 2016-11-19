<fieldset class="form-group">
    <label for="name">{{ $field->getConfig('label') }}</label>
    <textarea name="{{ $fieldName }}" class="form-control wysiwyg-textarea">@if($model){!! $model->{$fieldName} !!}@endif</textarea>
</fieldset>
