<li class="dd-item" data-widget="{{ $widget->get('key') }}" data-key="{{ $key }}">
    <div class="dd-handle">
        <span>{{ $widget->get('label') }}</span>
        <div class="dd-nodrag">
            <a href="javascript:void(0)" class="show-item-form">
                <i class="fa fa-sort-down"></i>
            </a>
        </div>
    </div>

    <div class="form-item-edit dd-nodrag box-hidden">
        <form action="" method="post" class="form-sidebar-widget">
            <input type="hidden" name="key" value="{{ $key }}">
            <input type="hidden" name="widget" value="{{ $widget->get('key') }}">

            {!! $widget['widget']->form($data ?? []) !!}

            <a href="javascript:void(0)" class="delete-item-form text-danger">
                <i class="fa fa-times"></i> {{ trans('juzaweb::app.delete') }}
            </a>
        </form>
    </div>
</li>