<fieldset class="form-group">
    <label for="name">{{ $field->getConfig('label') }}</label>
    <select class="form-control" name="{{ $field->fieldName }}">
        @foreach($options as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </select>
</fieldset>
