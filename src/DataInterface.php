<?php
/**
 * @link https://github.com/tigrov/intldata
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */

namespace tigrov\intldata;

interface DataInterface
{
    /**
     * Returns list of codes
     * @return array
     */
    public static function codes();

    /**
     * Returns a boolean indicating whether data has a code
     * @param string $code the code of the data
     * @return bool
     */
    public static function has($code);

    /**
     * Returns list of names with code keys [code => name]
     * @param string[]|null $codes the list of codes to get names, the empty value means all codes
     * @param bool $sort a boolean indicating to sort the result
     * @return array
     */
    public static function names($codes = null, $sort = true);

    /**
     * Returns name by a code
     * @param string $code the code
     * @return string
     */
    public static function name($code);
}