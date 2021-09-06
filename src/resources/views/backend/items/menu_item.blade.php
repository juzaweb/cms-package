@php
$data = $item->getAttributes();
@endphp
<li
    class="dd-item"
    @foreach($data as $key => $val)
        @if(!is_array($val))
            data-{{ $key }}="{{ $val }}"
        @endif
    @endforeach
>
    <div class="dd-handle">
        <span>{{ $data['name'] }}</span>
        <a href="javascript:void(0)" class="dd-nodrag show-menu-edit">
            <i class="fa fa-sort-down"></i>
        </a>
        {{--<a href="javascript:void(0)" class="dd-nodrag text-danger delete-menu-item">
            <i class="fa fa-trash"></i>
        </a>--}}
    </div>

    <div class="form-item-edit box-hidden">
        @php
            $register = $item->menuBox();
            $menuBox = $register->get('menu_box');
            $view = $menuBox->editView($item);
        @endphp

        @if(!empty($view))
            {!! $view !!}
        @endif

        <div class="form-group">
            <label class="col-form-label">{{ trans('juzaweb::app.target') }}</label>
            <select class="form-control menu-data" data-name="target">
                <option value="_self" @if($item->target == '_self') selected @endif>{{ trans('juzaweb::app.target_self') }}</option>
                <option value="_blank" @if($item->target == '_blank') selected @endif>{{ trans('juzaweb::app.target_blank') }}</option>
            </select>
        </div>

        <a href="javasctipt:void(0)" class="text-danger delete-menu-item">{{ trans('juzaweb::app.delete') }}</a>
        <a href="javasctipt:void(0)" class="text-info close-menu-item">{{ trans('juzaweb::app.cancel') }}</a>
    </div>

    @if(!empty($children))
        <ol class="dd-list">
        @foreach($children as $child)
            {!! $builder->buildItem($child) !!}
        @endforeach
        </ol>
    @endif

</li>