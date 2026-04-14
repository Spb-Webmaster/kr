@props([
    'title' => '',
    'name' => '',
    'label' => '',
    'class' => '',
    'selected' => '',
    'rand' => rand(100, 10000),
    'value' => '',
    'options' => [],
    'required' => false,
    'field_name' => '',
    'autoSubmit' => false

])
@if(count($options))
    <div class="input-group app_select_group @if($autoSubmit) autoSubmit @endif">

        @if($title)
            <h4 class="_group_title">{{ $title }}</h4>
        @endif

        <div class="select-box">
            <div class="options-container scroll-block">

                @if(count($options) > 0)
                    @foreach($options as $k=>$option)
                        <div class="option @if($option['key'] == $selected) active @endif">
                            <input type="radio" class="radio" id="{{'select_service' . $k . $rand}}"
                                   value="{{ $option['key'] }}"   />
                            <label data-id="{{ $option['key']}}" for="{{'select_service' . $k . $rand }}">{{ $option['value'] }}</label>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="selected {{ ($selected)?'active':''  }}"
                 data-select="{{ $name }}">{{ ($value)?:$name }} {!! ($required) ?'<span>*</span>':'' !!}</div>
            <div class="app_input_error input_error"></div>


            <div class="search-box">
                <input type="text" placeholder="Поиск..."/>
            </div>
            <div class="display_none">
                <input type="text" class="app_field_name" value="{{ $selected }}"
                       @if($field_name) name="{{ $field_name }}" @endif />
            </div>


        </div>
    </div>
@endif

