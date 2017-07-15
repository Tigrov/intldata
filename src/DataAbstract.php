<?php
/**
 * @link https://github.com/tigrov/intldata
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */

namespace tigrov\intldata;

abstract class DataAbstract implements DataInterface
{
    /**
     * @inheritdoc
     */
    public static function has($code)
    {
        return isset(static::codes()[$code]);
    }

    /**
     * @inheritdoc
     */
    public static function names($codes = null)
    {
        $list = [];
        $codes = $codes ?: static::codes();
        foreach ($codes as $code) {
            $list[$code] = static::name($code);
        }

        asort($list);

        return $list;
    }
}