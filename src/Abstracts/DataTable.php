<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 5/31/2021
 * Time: 9:55 PM
 */

namespace Juzaweb\Abstracts;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

abstract class DataTable
{
    protected $perPage = 10;

    /**
     * Columns datatable
     *
     * @return array
     */
    abstract public function columns();

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    abstract public function query($data);

    public function render($params)
    {
        $uniqueId = 'juzaweb_' . Str::random(10);
        $this->mount(...$params);

        return view('juzaweb::components.datatable', [
            'columns' => $this->columns(),
            'actions' => $this->actions(),
            'uniqueId' => $uniqueId,
            'params' => $this->paramsToArray($params),
            'table' => Crypt::encryptString(static::class),
        ]);
    }

    public function actions()
    {
        return [];
    }

    public function bulkActions($action, $ids)
    {
        //
    }

    private function paramsToArray($params)
    {
        foreach ($params as $key => $var) {
            if (!in_array(gettype($var), ['string', 'array', 'integer'])) {
                throw new \Exception('Mount data can\'t support. Only supported string, array, integer');
            }
        }

        return $params;
    }
}
