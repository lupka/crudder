<fieldset class="form-group">
    <label for="name">{{ $field->getConfig('label') }}</label>
    <input type="text" name="{{ $fieldName }}" class="form-control" value="@if($model){{ $model->{$fieldName} }}@endif">
</fieldset>
