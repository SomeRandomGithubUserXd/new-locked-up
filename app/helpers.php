<?php

if(!function_exists('define_as_bool')) {
    function define_as_bool($val): bool
    {
        return $val === 'true' || $val === true || $val === '1';
    }
}
