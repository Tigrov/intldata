<?php

namespace tigrov\intldata;

interface DataInterface
{
    /**
     * Get list of codes.
     *
     * @return array list of codes.
     */
    public static function codes();

    /**
     * Get list of names.
     *
     * @return array list of names
     */
    public static function names();

    /**
     * Get name by code.
     *
     * @param string $code code
     * @return string name
     */
    public static function name($code);
}