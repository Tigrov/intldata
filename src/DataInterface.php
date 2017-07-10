<?php
/**
 * @link https://github.com/tigrov/intldata
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */

namespace tigrov\intldata;

interface DataInterface
{
    /**
     * Returns list of codes.
     * @return array list of codes.
     */
    public static function codes();

    /**
     * Returns a boolean indicating whether data has a code.
     * @param string $code the code of the data
     * @return bool
     */
    public static function has($code);

    /**
     * Returns list of names.
     * @return array list of names
     */
    public static function names();

    /**
     * Returns name by code.
     * @param string $code code
     * @return string name
     */
    public static function name($code);
}