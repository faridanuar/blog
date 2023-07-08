<?php

namespace App\Utilities;

class OptionList
{
    public static function list()
    {
        $list['yes-no'] = [
            0 => 'No',
            1 => 'Yes'
        ];

        return $list;
    }

    public static function render(String $name)
    {
        $list = static::list();

        if (isset($list[$name])) {
            return $list[$name];
        }

        return null;
    }

    public static function value(String $name, $value)
    {
        $list = static::list();

        if (isset($list[$name])) {
            if (isset($list[$name][$value])) {
                return $list[$name][$value];
            }
        }

        return null;
    }
}
