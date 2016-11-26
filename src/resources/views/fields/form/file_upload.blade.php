<fieldset class="form-group">
    <label for="name">{{ $field->getConfig('label') }}</label>
    <input type="file" name="{{ $fieldName }}" class="form-control">
    @if($model){{ $model->{$fieldName} }}@endif
</fieldset>
