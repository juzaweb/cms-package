<div class="card sidebar-item">
    <div class="card-header">
        <h5>{{ $item->get('label') }}</h5>

        <div class="text-right right-actions">
            <a href="javascript:void(0)" class="show-edit-form">
                <i class="fa fa-sort-down fa-2x"></i>
            </a>
        </div>
    </div>

    <div class="card-body box-hidden">
        <div class="dd jw-widget-builder">
            <ol class="dd-list">
                <li class="dd-item">
                    <div class="dd-handle">
                        <span>The following code</span>
                        <a href="javascript:void(0)" class="dd-nodrag">
                            <i class="fa fa-sort-down"></i>
                        </a>
                    </div>

                    <div class="form-item-edit box-hidden">

                    </div>
                </li>
            </ol>
        </div>
    </div>
</div>

<textarea name="content" class="form-control box-hidden"></textarea>