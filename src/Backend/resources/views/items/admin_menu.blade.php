@foreach($items as $item)
    @if($item->hasChildren())
        <li class="juzacms__menuLeft__item juzacms__menuLeft__submenu juzacms__menuLeft__item-{{ $item->get('url') }}">
            <span class="juzacms__menuLeft__item__link">
                <i class="juzacms__menuLeft__item__icon {{ $item->get('icon') }}"></i>

                <span class="juzacms__menuLeft__item__title">{{ $item->get('title') }}</span>
            </span>

            <ul class="juzacms__menuLeft__navigation">
            @foreach($item->getChildrens() as $child)
                <li class="juzacms__menuLeft__item juzacms__menuLeft__item-{{ $child->get('url') }}">
                    <a class="juzacms__menuLeft__item__link" href="{{ url('admin-cp/' . $child->get('url')) }}">
                        <span class="juzacms__menuLeft__item__title">{{ trans($child->get('title')) }}</span>
                        {{--<i class="juzacms__menuLeft__item__icon fe fe-film"></i>--}}
                    </a>
                </li>
            @endforeach
            </ul>
        </li>
    @else
        <li class="juzacms__menuLeft__item juzacms__menuLeft__item-{{ $item->get('url') }}">
            <a class="juzacms__menuLeft__item__link" href="{{ url('admin-cp/' . $item->get('url')) }}">
                <i class="juzacms__menuLeft__item__icon {{ $item->get('icon') }}"></i>
                <span class="juzacms__menuLeft__item__title">{{ $item->get('title') }}</span>

            </a>
        </li>
    @endif
@endforeach