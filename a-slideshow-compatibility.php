<?php
/**
 * Requried for PHP4
 * 
 * @package WordPress
 * @subpackage (a) Slideshow
 */

if (!function_exists('array_diff_key')) {
    /**
     * array_diff_key for PHP4
     *
     * @return array
     */
    function array_diff_key()
    {
        $args = func_get_args();
        return array_flip(call_user_func_array('array_diff',
               array_map('array_flip',$args)));
    }
}

if (!function_exists('json_encode')) {
    /**
     * json_encode
     *
     * json_encode simple version for current plugin
     *
     * @access  public
     * @param   mixed    $var 
     * @return  string
     */
    function json_encode($var) 
    {
        $res = '{';
        foreach ($var as $key => $value) {
            if (is_array($value)) {
                $res .= "\n\t".$key .':'. json_encode($value).',';
            } elseif (is_numeric($value)) {
                $res .= "\n\t".$key .':'.$value.',';
            } elseif (is_bool($value)) {
                $res .= "\n\t".$key .':'.($value?"true":"false").',';
            } else {
                // Escape these characters with a backslash:
                // " \ / \n \r \t \b \f
                $search  = array('\\', "\n", "\t", "\r", "\b", "\f", '"');
                $replace = array('\\\\', '\\n', '\\t', '\\r', '\\b', '\\f', '\"');
                $string  = str_replace($search, $replace, $value);
        
                // Escape certain ASCII characters:
                // 0x08 => \b
                // 0x0c => \f
                $string = str_replace(array(chr(0x08), chr(0x0C)), array('\b', '\f'), $string);
                
                $res .= "\n\t".$key .':"'.$string.'",';
            }
        }
        $res = rtrim($res, ',');
        $res .= '}';
        
        return $res;
    }
}