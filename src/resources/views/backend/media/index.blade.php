@extends('juzaweb::layouts.backend')

@section('content')

    <div id="media-container">
        <div class="box-hidden media-upload-form">
            <div class="row mb-5">
                <div class="col-md-12">
                <form action="{{ route('filemanager.upload') }}" role='form' id='uploadForm' name='uploadForm' method='post' class="dropzone" enctype='multipart/form-data'>

                    <div class="form-group" id="attachment">
                        <div class="controls text-center">
                            <div class="input-group w-100">
                                <a class="btn btn-primary w-100 text-white" id="upload-button">{{ trans('juzaweb::filemanager.message-choose') }}</a>
                            </div>
                        </div>
                    </div>

                    <input type='hidden' name='working_dir' id='working_dir' value="{{ $folderId }}">
                    <input type='hidden' name='type' id='type' value='{{ $type }}'>
                    <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                </form>
            </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-8">
                <form action="" method="get" class="form-inline">
                    <input type="text" class="form-control w-25" name="search" placeholder="{{ trans('juzaweb::app.search_by_name') }}" autocomplete="off">

                    <select name="type" class="form-control w-25 ml-1">
                        <option value="">{{ trans('juzaweb::app.all_type') }}</option>
                        @foreach($fileTypes as $key => $val)
                            <option value="{{ $key }}" {{ $type == $key ? 'selected' : '' }}>{{ strtoupper($key) }}</option>
                        @endforeach
                    </select>

                    {{--<select name="mime" class="form-control w-25 ml-1">
                        <option value="">All media items</option>
                        <option value="image">Images</option>
                        <option value="audio">Audio</option>
                        <option value="video">Video</option>
                        <option value="application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-word.document.macroEnabled.12,application/vnd.ms-word.template.macroEnabled.12,application/vnd.oasis.opendocument.text,application/vnd.apple.pages,application/pdf,application/vnd.ms-xpsdocument,application/oxps,application/rtf,application/wordperfect,application/octet-stream">Documents</option>
                        <option value="application/vnd.apple.numbers,application/vnd.oasis.opendocument.spreadsheet,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel.sheet.macroEnabled.12,application/vnd.ms-excel.sheet.binary.macroEnabled.12">Spreadsheets</option>
                        <option value="application/x-gzip,application/rar,application/x-tar,application/zip,application/x-7z-compressed">Archives</option>
                        <option value="unattached">Unattached</option>
                        <option value="mine">Mine</option>
                    </select>--}}

                    <button type="submit" class="btn btn-primary ml-1">@lang('juzaweb::app.search')</button>
                </form>
            </div>

            <div class="col-md-4">
                <div class="btn-group float-right">
                    <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#add-folder-modal"><i class="fa fa-plus"></i> {{ trans('juzaweb::app.add_folder') }}</a>
                    <a href="javascript:void(0)" class="btn btn-success show-form-upload"><i class="fa fa-cloud-upload"></i> {{ trans('juzaweb::app.upload') }}</a>
                </div>
            </div>
        </div>

        <div class="list-media mt-5">
            <ul class="media-list">
                @foreach($mediaItems as $item)
                    <li class="media-item">
                        <a @if($item->is_file) href="javascript:void(0)" @else href="{{ route('admin.media.folder', [$item->id]) }}" @endif>
                            <div class="attachment-preview">
                                <div class="thumbnail @if(empty($item->is_file)) media-folder @endif">
                                    <div class="centered">
                                        @if($item->thumb)
                                        <img src="{{ $item->thumb }}" alt="{{ $item->name }}">
                                        @else
                                            <i class="fa {{ $item->icon }} fa-3x"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{--<div class="">
                                <div class="text-dark text-uppercase font-weight-bold mr-auto">
                                    {{ $item->name }}
                                </div>
                                --}}{{--<div class="text-gray-6">
                                    <button class="btn btn-primary">Activate</button>
                                </div>--}}{{--
                            </div>--}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>



@endsection

@section('footer')

    <script>
        Dropzone.autoDiscover = false;

        document.addEventListener("turbolinks:load", function () {
            new Dropzone("#uploadForm", {
                paramName: "upload",
                uploadMultiple: false,
                parallelUploads: 5,
                timeout: 0,
                clickable: '#upload-button',
                dictDefaultMessage: "{{ trans('juzaweb::filemanager.message-drop') }}",
                init: function () {
                    var _this = this; // For the closure
                    this.on('success', function (file, response) {
                        if (response == 'OK') {
                            Turbolinks.visit("", {action: "replace"});
                        }
                        else {
                            this.defaultOptions.error(file, response.join('\n'));
                        }
                    });
                },
                headers: {
                    'Authorization': "Bearer {{ csrf_token() }}"
                },
                acceptedFiles: "{{ implode(',', $mimeTypes) }}",
                maxFilesize: parseInt("{{ $maxSize }}"),
                chunking: true,
                chunkSize: 1048576,
            });
        });

        function add_folder_success(form) {
            Turbolinks.visit("", {action: "replace"});
        }
    </script>

    <div class="modal fade" id="add-folder-modal" tabindex="-1" role="dialog" aria-labelledby="add-folder-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.media.add-folder') }}" method="post" class="form-ajax" data-success="add_folder_success">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="add-folder-modal-label">
                            {{ trans(('juzaweb::app.add_folder')) }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('juzaweb::app.close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @component('juzaweb::components.form_input', [
                            'label' => trans('juzaweb::app.folder_name'),
                            'name' => 'name'
                        ])
                        @endcomponent

                        <input type="hidden" name="folder_id" value="{{ $folderId }}">
                        <input type="hidden" name="type" value="{{ $type }}">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> @lang('juzaweb::app.close')</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('juzaweb::app.add_folder')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection