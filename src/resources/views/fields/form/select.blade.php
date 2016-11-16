<fieldset class="form-group">
    <label for="name">{{ $field->getConfig('label') }}</label>
    <select class="form-control" name="{{ $fieldName }}">
        @foreach($field->getConfig('options', []) as $value => $option)
            <option value="{{ $value }}"@if($model && $model->{$fieldName} == $value)selected="selected"@endif>{{ $option }}</option>
        @endforeach
    </select>
</fieldset>
