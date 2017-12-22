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
        return in_array($code, static::codes());
    }

    /**
     * @inheritdoc
     */
    public static function names($codes = null, $sort = true)
    {
        $list = [];
        $codes = $codes ?: static::codes();
        foreach ($codes as $code) {
            $list[$code] = static::name($code);
        }

        if ($sort) {
            asort($list);
        }

        return $list;
    }
}