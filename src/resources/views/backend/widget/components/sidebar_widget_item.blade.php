<li class="dd-item">
    <div class="dd-handle">
        <span>{{ $label }}</span>
        <a href="javascript:void(0)" class="dd-nodrag">
            <i class="fa fa-sort-down"></i>
        </a>
    </div>

    <div class="form-item-edit box-hidden">
        {!! $slot ?? '' !!}
    </div>
</li>