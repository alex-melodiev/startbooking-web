<input type="hidden" name="{{ $field['name'] }}" class="form-control {{ @$field['class'] }}" id="{{ $field['id'] or $field['name'] }}" value="{{ $_POST[$field['name']] or $field['value'] }}" placeholder="{{ $field['label'] }}">
