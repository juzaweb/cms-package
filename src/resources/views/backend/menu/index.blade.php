@extends('juzaweb::layouts.backend')

@section('content')
    <div id="menu-container">
        <div class="row alert alert-light p-3 no-radius">

            <div class="col-md-6 form-select-menu">
                <div class="alert-default">
                    @lang('juzaweb::app.select_menu_to_edit'):
                    <select name="id" class="w-25 form-control load-menu">
                        @if(isset($menu->id))
                            <option value="{{ $menu->id }}" selected>{{ $menu->name }}</option>
                        @endif
                    </select>

                    @lang('juzaweb::app.or') <a href="javascript:void(0)" class="ml-1 btn-add-menu"><i class="fa fa-plus"></i> {{ trans('juzaweb::app.create_new_menu') }}</a>
                </div>
            </div>

            <div class="col-md-6 form-add-menu box-hidden">
                <form action="{{ route('admin.menu.store') }}" method="post" class="form-ajax form-inline">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" autocomplete="off" required placeholder="{{ trans('juzaweb::app.menu_name') }}">
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('juzaweb::app.add_menu') }}</button>
                </form>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-4">
                <h5 class="mb-2 font-weight-bold">{{ trans('juzaweb::app.add_menu_items') }}</h5>

                @do_action('juzaweb.add_menu_items')

            </div>

            <div class="col-md-8">
                <h5 class="mb-2 font-weight-bold">{{ trans('juzaweb::app.menu_structure') }}</h5>

                <form action="{{ route('admin.menu.update', [$menu->id ?? '']) }}" method="post" class="form-ajax form-menu-structure">
                    <input type="hidden" name="id" value="{{ $menu->id ?? '' }}">
                    <input type="hidden" name="reload_after_save" value="0">

                    @method('PUT')

                    <div class="card">
                        <div class="card-header bg-light pb-1">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3">{{ trans('juzaweb::app.menu_name') }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="name" id="name" class="form-control" value="{{ $menu->name ?? '' }}" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="btn-group float-right">
                                        <button type="submit" class="btn btn-primary" @if(empty($menu)) disabled @endif><i class="fa fa-save"></i> {{ trans('juzaweb::app.save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body" id="form-menu">
                            <div class="dd" id="jw-menu-builder">
                                <ol class="dd-list">
                                    @if($menu)
                                        {!! jw_nav_menu([
                                            'menu' => $menu,
                                            'item_view' => view('jw_theme::backend.items.menu_item'),
                                        ]) !!}
                                    @endif
                                </ol>
                            </div>
                        </div>

                        <div class="card-footer">
                            @if(!empty($menu))
                                <div class="btn-group">
                                    <a href="javascript:void(0)" class="text-danger delete-menu" data-id="{{ $menu->id }}">{{ trans('juzaweb::app.delete_menu') }}</a>
                                </div>
                            @endif

                            <div class="btn-group float-right">
                                <button type="submit" class="btn btn-primary" @if(empty($menu)) disabled @endif><i class="fa fa-save"></i> {{ trans('juzaweb::app.save') }}</button>
                            </div>
                        </div>

                        <textarea name="content" id="items-output" class="form-control box-hidden"></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection