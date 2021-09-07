<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label">{{ trans('juzaweb::app.menu') }}</label>
    <select name="theme[{{ $args->get('settings') }}]" class="load-menu">
        @php
        $menu = \Juzaweb\Models\Menu::find(get_theme_mod($args->get('settings')));
        @endphp
        @if($menu)
            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
        @endif
    </select>
</div>
