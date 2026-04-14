@if($menu_rendered)
    @foreach($menu_rendered as $item)

        <li class="{{ $item['class_li'] }} @if($item['parent']) parent @endif {{ active_linkMenu(($item['link']=='/')?$item['link']:asset($item['link']), 'find') }} {{active_linkParentMenu((isset($item['child']))? $item['child']:null)}}">

            <a class="{{ $item['class'] }}" {{ $item['data'] }} href="{{ asset($item['link']) }}">{{ $item['text'] }} @if($item['parent'])<em class="arrow"></em>@endif</a>

            @if($item['parent'])
                @if(isset($item['child']))
                    <ul class="submenu">
                        @foreach($item['child'] as $item_child)
                            <li class="{{ $item_child['class_li'] }} {{ active_linkMenu(asset($item_child['link']), 'find') }}">
                                <a class="{{ $item_child['class'] }}" {{ $item_child['data'] }} href="{{ asset($item_child['link']) }}">{{ $item_child['text'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endif

        </li>

    @endforeach
@endif
