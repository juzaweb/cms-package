<div class="card p-3">
    <div class="d-flex flex-row mb-3">
        <img src="{{ $item->image }}" width="70" height="70">
        <div class="d-flex flex-column ml-2">
            <span>{{ $item->title }}</span>
            {{--<span class="text-black-50">Payment Services</span>--}}

            <span class="ratings text-secondary">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
    <h6>{{ $item->description }}</h6>
    <div class="d-flex justify-content-between install mt-3">
        {{--<span>Installed 172 times</span>--}}
        <button class="btn btn-primary plugin-install" data-plugin="{{ $item->code }}">
            Install
        </button>

        <a target="_blank" href="{{ $item->url }}" class="text-primary">
            View&nbsp;<i class="fa fa-angle-right"></i>
        </a>
    </div>
</div>