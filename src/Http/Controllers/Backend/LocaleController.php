<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Cms\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Juzaweb\Cms\Facades\Locale;
use Juzaweb\Cms\Http\Controllers\BackendController;
use Juzaweb\Cms\Traits\ArrayPagination;

class LocaleController extends BackendController
{
    use ArrayPagination;

    public function index($type, $locale)
    {
        $data = Locale::getByKey($type);
        $language = config('locales.' . $locale . '.name');

        if (empty($data)) {
            return abort(404);
        }

        $this->addBreadcrumb([
            'title' => trans('juzaweb::app.translations'),
            'url' => route('admin.translations.index')
        ]);

        $this->addBreadcrumb([
            'title' => $data->get('title'),
            'url' => route('admin.translations.type', [$type])
        ]);

        return view('jw_trans::translation.locale', [
            'title' => $language,
            'data' => $data,
            'type' => $type,
            'locale' => $locale,
        ]);
    }

    public function save(Request $request, $type, $locale)
    {
        $data = Locale::getByKey($type);
        $keys = explode('.', $request->post('key'));
        $value = $request->post('value');

        $file = $keys[0] . '.php';
        unset($keys[0]);

        $lang = [];
        $folderPath = resource_path($data['publish_path'] . '/' . $locale);
        $filePath = $folderPath . '/' . $file;

        if (!is_dir($folderPath)) {
            try {
                File::makeDirectory($folderPath, 0775, true);
            } catch (\Throwable $e) {
                return $this->error([
                    'message' => $e->getMessage(),
                ]);
            }
        }

        if (file_exists($filePath)) {
            $lang = require ($filePath);
        }

        $keys = collect($keys)->values()->toArray();
        $lang = $this->setKeyLang($keys, $value, $lang);

        $strArr = $this->varExportShort($lang) . ";";
        $fileContent = "<?php \n";
        $fileContent .= "return $strArr \n";
        $fileContent .= "\n";

        try {
            File::put($filePath, $fileContent);
        } catch (\Throwable $e) {
            return $this->error([
                'message' => $e->getMessage(),
            ]);
        }

        return $this->success([
            'message' => 'ok',
        ]);
    }

    public function getDataTable(Request $request, $type, $locale)
    {
        $search = $request->get('search');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 10);
        $page = $offset <= 0 ? 1 : (round($offset / $limit)) + 1;

        $result = Locale::getAllTrans($type, $locale);

        if ($search) {
            $result = collect($result)->filter(function ($item) use ($search) {
                return (
                    strpos($item['key'], $search) !== false ||
                    strpos($item['value'], $search) !== false
                );
            });
        }

        $total = count($result);
        $items = $this->arrayPaginate($result, $limit, $page)->values();

        return response()->json([
            'total' => $total,
            'rows' => $items
        ]);
    }

    protected function setKeyLang($keys, $value, $lang)
    {
        foreach ($keys as $index => $key) {
            if (isset($keys[$index + 1])) {
                unset($keys[$index]);
                $keys = collect($keys)->values()->toArray();
                $lang[$key] = $this->setKeyLang($keys, $value, $lang[$key] ?? []);
                return $lang;
            } else {
                $lang[$key] = $value;
            }
        }

        return $lang;
    }

    protected function varExportShort($var) {
        $output = json_decode(
            str_replace(
                ['(', ')'],
                ['&#40', '&#41'],
                json_encode($var)
            ), true);

        $output = var_export($output, true);
        $output = str_replace(
            ['array (', ')', '&#40', '&#41'],
            ['[',']','(',')'],
            $output
        );

        return $output;
    }
}