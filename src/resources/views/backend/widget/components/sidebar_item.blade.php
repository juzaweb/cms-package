<div class="card sidebar-item" id="sidebar-{{ $item->get('key') }}">
    <div class="card-header">
        <h5>{{ $item->get('label') }}</h5>

        <div class="text-right right-actions">
            <a href="javascript:void(0)" class="show-edit-form">
                <i class="fa fa-sort-down fa-2x"></i>
            </a>
        </div>
    </div>

    <div class="card-body box-hidden">
        <div class="dd jw-widget-builder" data-key="{{ $item->get('key') }}">
            <ol class="dd-list">

            </ol>
        </div>
    </div>
</div>

<textarea name="content" class="form-control box-hidden" id="items-output-{{ $item->get('key') }}"></textarea>