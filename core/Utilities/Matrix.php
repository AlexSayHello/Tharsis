<?php namespace Core\Utilities;

class Matrix {

    public static function removeEmptyString ( $array ) {
        $params = $array;

        foreach ( $params as $index=>$param ) {
            if ( $param == "" )
            {
                unset( $params[$index] );
            }
        }

        return $params;
    }

    public static function deleteSignKey ( Array $array ) {

        foreach ( $array as $key=>$element ) {
            $array[ $key ] = preg_replace("/[{}]/", "", $element );
        }

        return $array;
    }
}