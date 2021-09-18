<?php

namespace Juzaweb\Http\Controllers\FileManager;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Juzaweb\Models\MediaFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Illuminate\Http\UploadedFile;

class UploadController extends FileManagerController
{
    protected $errors = [];
    
    public function upload(Request $request)
    {
        $folder_id = $request->input('working_dir');
        
        if (empty($folder_id)) {
            $folder_id = null;
        }

        $new_filename = null;
        $new_path = null;
    
        try {
            $receiver = new FileReceiver('upload', $request, HandlerFactory::classFromRequest($request));
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }
            
            $save = $receiver->receive();
            if ($save->isFinished()) {
                $this->saveFile($save->getFile(), $folder_id);
                return $this->response($this->errors);
            }
    
            $handler = $save->handler();
    
            return response()->json([
                "done" => $handler->getPercentageDone(),
                'status' => true
            ]);
        
        } catch (\Exception $e) {
            Log::error($e);
            array_push($this->errors, $e->getMessage());
            return $this->response($this->errors);
        }
    }
    
    protected function saveFile(UploadedFile $file, $folderId) {
        if (!$this->validateFile($file)) {
            return $this->response($this->errors);
        }

        $filename = $this->createFilename($file);
        $storage = Storage::disk(config('juzaweb.filemanager.disk'));
        $newPath = $storage->putFileAs(date('Y/m/d'), $file, $filename);
    
        if ($newPath) {
            DB::beginTransaction();
            try {
                $model = new MediaFile();
                $model->name = $file->getClientOriginalName();
                $model->path = $newPath;
                $model->type = $this->getType();
                $model->mime_type = $file->getClientMimeType();
                $model->extension = $file->getClientOriginalExtension();
                $model->size = $file->getSize();
                $model->folder_id = $folderId;
                $model->user_id = Auth::id();
                $model->save();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
        
        return $newPath;
    }
    
    protected function createFilename(UploadedFile $file)
    {
        $filename = substr($file->getClientOriginalName(), 0, 110);
        $extension = $file->getClientOriginalExtension();
        $newFileName = Str::slug(basename($filename, "." . $extension)) .'-'. time() .'-'. Str::random(10) .'.' . $extension;
        return $newFileName;
    }
    
    protected function response($error_bag)
    {
        $response = count($error_bag) > 0 ? $error_bag : parent::$success_response;
        return response()->json($response);
    }

    protected function validateFile(UploadedFile $file)
    {
        $type = $this->getType();
        $config = config('juzaweb.filemanager.types.' . $type);

        if (empty($config)) {
            array_push($this->errors, 'File type not support.');
            return false;
        }

        if (!in_array($file->getClientMimeType(), $config['valid_mime'])) {
            array_push($this->errors, trans('juzaweb::filemanager.error-mime'));
            return false;
        }

        if ($file->getSize() > $config['max_size'] * 1024 * 1024) {
            array_push($this->errors, trans('juzaweb::filemanager.error-size'));
            return false;
        }

        return true;
    }
}
