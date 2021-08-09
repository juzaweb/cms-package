<ul class="juzacms__menuLeft__navigation">
    @php
        $items = \Juzaweb\Cms\Core\Helpers\MenuCollection::make(apply_filters('juzacms.admin_menu', []));
    @endphp

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
                            <a class="juzacms__menuLeft__item__link" href="{{ url('admin-cp/' . $child->get('url')) }}" @if($child->get('turbolinks') === false) data-turbolinks="false" @endif>
                                <span class="juzacms__menuLeft__item__title">{{ trans($child->get('title')) }}</span>

                                @if($icon = $child->get('icon'))
                                <i class="juzacms__menuLeft__item__icon {{ $icon }}"></i>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
            <li class="juzacms__menuLeft__item juzacms__menuLeft__item-{{ $item->get('url') }}">
                <a class="juzacms__menuLeft__item__link" href="{{ url('admin-cp/' . $item->get('url')) }}" @if($item->get('turbolinks') === false) data-turbolinks="false" @endif>
                    <i class="juzacms__menuLeft__item__icon {{ $item->get('icon') }}"></i>
                    <span class="juzacms__menuLeft__item__title">{{ $item->get('title') }}</span>

                </a>
            </li>
        @endif
    @endforeach
</ul>