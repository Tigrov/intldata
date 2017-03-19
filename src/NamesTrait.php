<?php
/**
 * @link https://github.com/tigrov/intldata
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */

namespace tigrov\intldata;

trait NamesTrait
{
    /**
     * Get list of names.
     *
     * @return array list of names
     */
    public static function names()
    {
        static $list;

        if ($list === null) {
            $list = [];
            foreach (static::codes() as $code) {
                $list[$code] = static::name($code);
            }

            asort($list);
        }

        return $list;
    }
}