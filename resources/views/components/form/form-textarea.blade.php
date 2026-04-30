@props([
    'name' => '',
    'label' => '',
    'class' => '',
    'rand' => rand(100, 10000),
    'autocomplete' => 'off',
    'value' => '',
    'autofocus' => false,
    'required' => false,
    'error' => '',
    'description' => '',
    'editor' => false
])

@if($editor)

    @once
        @push('styles')
            <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
        @endpush
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        @endpush
    @endonce

    <div class="quill-field-wrap">
        <input type="hidden" name="{{ $name }}" id="quill-input-{{ $rand }}" value="{{ $value }}">
        <div id="quill-editor-{{ $rand }}"></div>
    </div>

    @push('scripts')
    <script>
    (function () {
        var quill = new Quill('#quill-editor-{{ $rand }}', {
            theme: 'snow',
            placeholder: '{{ addslashes($label) }}',
            modules: {
                toolbar: [
                    [{ header: [2, 3, false] }],
                    ['bold', 'italic'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['clean']
                ],
                clipboard: { matchVisual: false }
            }
        });

        var initial = document.getElementById('quill-input-{{ $rand }}').value;
        if (initial) {
            quill.clipboard.dangerouslyPasteHTML(initial);
            quill.history.clear();
        }

        var form = document.getElementById('quill-input-{{ $rand }}').closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                document.getElementById('quill-input-{{ $rand }}').value =
                    quill.root.innerHTML.replace(/&nbsp;/g, ' ');
            });
        }
    })();
    </script>
    @endpush

@else

    <div class="input-group app_input_group">
        <textarea class="input-group__input app_input_name {{ $class }} @error(($error)?:$name) _error @enderror" placeholder="" name="{{ $name }}" id="{{ $name . $rand }}" autocomplete="{{ $autocomplete }}" {{ $autofocus ? 'autofocus' : '' }}>{{ $value }}</textarea>
        <label class="input-group__label" for="{{ $name . $rand }}">{{ $label }} {!! $required ? '<span>*</span>' : '' !!}</label>
        <div class="input_error app_input_error">@error(($error)?:$name){{ $message }}@enderror</div>
    </div>

@endif

