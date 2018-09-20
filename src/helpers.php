<?php

if ( ! function_exists('truncate') ) {

    function truncate($string, $length)
    {
        if ( strlen($string) > $length ) {
            $string = substr($string, 0, $length) . '...';
        }

        return $string;
    }
}