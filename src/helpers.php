<?php

if ( ! function_exists('truncate') ) {

    /**
     * @param   string  $string
     * @param   int  $length
     * @return  string
     */
    function truncate($string, $length)
    {
        if ( strlen($string) > $length ) {
            $string = substr($string, 0, $length) . '...';
        }

        return $string;
    }
}