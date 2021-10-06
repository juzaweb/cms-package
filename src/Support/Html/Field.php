<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Support\Html;

use Juzaweb\Models\Model;

class Field
{
    public static function text($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('juzaweb::components.form_input', $options);
    }

    public static function textarea($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('juzaweb::components.form_textarea', $options);
    }

    public static function select($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('juzaweb::components.form_select', $options);
    }

    public static function slug($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('juzaweb::components.form_slug', $options);
    }

    public static function editor($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('juzaweb::components.form_ckeditor', $options);
    }

    public static function selectTaxonomy($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('juzaweb::components.form_select', $options);
    }

    public static function image($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('juzaweb::components.form_image', $options);
    }

    public static function mapOptions($label, $name, $options = [])
    {
        $options['name'] = $name;

        if ($label instanceof Model) {
            $options['value'] = $label->getAttribute($name);
            $options['label'] = $label->attributeLabel($name);
        }

        if (is_string($label)) {
            $options['label'] = $label;
        }

        return $options;
    }
}
