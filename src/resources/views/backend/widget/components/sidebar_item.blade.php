<div class="card">
    <div class="card-header pt-0 pb-1">
        {{ $item->get('label') }}
        <div class="text-right">
            <a href="javascript:void(0)"><i class="fa fa-sort-down fa-2x"></i></a>
        </div>
    </div>

    <div class="card-body">
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

<textarea name="content" id="items-output" class="form-control box-hidden"></textarea>