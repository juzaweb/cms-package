<li class="dd-item" data-widget="{{ $widget->get('key') }}" data-key="{{ $key }}">
    <div class="dd-handle">
        <span>{{ $widget->get('label') }}</span>
        <a href="javascript:void(0)" class="dd-nodrag show-item-form">
            <i class="fa fa-sort-down"></i>
        </a>
    </div>

    <div class="form-item-edit box-hidden">
        <form action="" method="post">
            @csrf

            @method('PUT')

            <input type="hidden" name="key" value="{{ $key }}">

            {!! $widget['widget']->form() !!}
        </form>
    </div>
</li>