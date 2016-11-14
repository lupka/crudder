<fieldset class="form-group">
    <label for="name">{{ $field->getConfig('label') }}</label>
    <input type="checkbox" name="{{ $fieldName }}" class="form-control" value="1" @if($model->{$fieldName})checked="checked"@endif)>
</fieldset>
