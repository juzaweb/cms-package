<li class="dd-item" data-widget="{{ $widget->get('key') }}" data-key="{{ $key }}">
    <div class="dd-handle">
        <span>{{ $widget->get('label') }}</span>
        <a href="javascript:void(0)" class="dd-nodrag show-item-form">
            <i class="fa fa-sort-down"></i>
        </a>
    </div>

    <div class="form-item-edit dd-nodrag box-hidden">
        <form action="" method="post" class="form-sidebar-widget">
            @csrf

            @method('PUT')

            <input type="hidden" name="key" value="{{ $key }}">
            <input type="hidden" name="widget" value="{{ $widget->get('key') }}">

            {!! $widget['widget']->form($data ?? []) !!}
        </form>
    </div>
</li>