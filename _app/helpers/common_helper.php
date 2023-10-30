<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('startsWith')) {

    function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

}

if (!function_exists('endsWith')) {

    function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }

}

if (!function_exists('convert_month')) {

    function convert_month($month, $lang = 'en') {
        $month = (int) $month;
        switch ($lang) {
            case 'id':
                $arr_month = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
                break;

            default:
                $arr_month = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                break;
        }

        if(array_key_exists($month - 1, $arr_month)) {
            $month_converted = $arr_month[$month - 1];
        } else {
            $month_converted = '';
        }

        return $month_converted;
    }

}

if (!function_exists('convert_month_chart')) {

    function convert_month_chart($month, $lang = 'en') {
        $month = (int) $month;
        switch ($lang) {
            case 'id':
                $arr_month = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des');
                break;

            default:
                $arr_month = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'November', 'Dec');
                break;
        }

        if(array_key_exists($month - 1, $arr_month)) {
            $month_converted = $arr_month[$month - 1];
        } else {
            $month_converted = '';
        }

        return $month_converted;
    }

}


if (!function_exists('convert_date')) {

    function convert_date($date, $lang = 'en', $type = 'text', $format = '.') {
        if (!empty($date) && $date != '0000-00-00') {
            $date = substr($date, 0, 10);
            if ($type == 'num') {
                $date_converted = str_replace('-', $format, $date);
            } else {
                $year = substr($date, 0, 4);
                $month = substr($date, 5, 2);
                $month = convert_month($month, $lang);
                $day = substr($date, 8, 2);

                $date_converted = $day . ' ' . $month . ' ' . $year;
            }
        } else {
            $date_converted = '-';
        }
        return $date_converted;
    }

}


if (!function_exists('convert_date_chart')) {

    function convert_date_chart($date, $lang = 'id', $type = 'text', $format = '.') {
        if (!empty($date) && $date != '0000-00-00') {
            $date = substr($date, 0, 10);
            if ($type == 'num') {
                $date_converted = str_replace('-', $format, $date);
            } else {
                $year = substr($date, 0, 4);
                $month = substr($date, 5, 2);
                $month = convert_month_chart($month, $lang);
                $day = substr($date, 8, 2);

                $date_converted = $day . ' ' . $month . ' ' . $year;
            }
        } else {
            $date_converted = '-';
        }
        return $date_converted;
    }

}


if (!function_exists('convert_datetime')) {

    function convert_datetime($date, $lang = 'en', $type = 'text', $formatdate = '.', $formattime = ':') {

        if (!empty($date)) {
            if ($type == 'num') {
                $date_converted = str_replace('-', $formatdate, str_replace(':', $formattime, $date));
            } else {
                $year = substr($date, 0, 4);
                $month = substr($date, 5, 2);
                $month = convert_month($month, $lang);
                $day = substr($date, 8, 2);
                $time = strlen($date) > 10 ? substr($date, 11, 8) : '';
                $time = str_replace(':', $formattime, $time);

                $date_converted = $day . ' ' . $month . ' ' . $year . ' ' . $time;
            }
        } else {
            $date_converted = '-';
        }
        return $date_converted;
    }

}


if (!function_exists('get_filesize')) {

    function get_filesize($file) {
        $bytes = array("B", "KB", "MB", "GB", "TB", "PB");
        $file_with_path = $file;
        $file_with_path;
        // replace (possible) double slashes with a single one
        $file_with_path = str_replace("///", "/", $file_with_path);
        $file_with_path = str_replace("//", "/", $file_with_path);
        $size = @filesize($file_with_path);
        $i = 0;

        //divide the filesize (in bytes) with 1024 to get "bigger" bytes
        while ($size >= 1024) {
            $size = $size / 1024;
            $i++;
        }

        // you can change this number if you like (for more precision)
        if ($i > 1) {
            return round($size, 1) . " " . $bytes[$i];
        } else {
            return round($size, 0) . " " . $bytes[$i];
        }
    }

}

if (!function_exists('slug')) {
    function slug($text){
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }
}

if (!function_exists('html_cut')) {
    function html_cut($text, $max_length){
        $tags   = array();
        $result = "";

        $is_open   = false;
        $grab_open = false;
        $is_close  = false;
        $in_double_quotes = false;
        $in_single_quotes = false;
        $tag = "";

        $i = 0;
        $stripped = 0;

        $stripped_text = strip_tags($text);

        while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length)
        {
            $symbol  = $text{$i};
            $result .= $symbol;

            switch ($symbol)
            {
               case '<':
                    $is_open   = true;
                    $grab_open = true;
                    break;

               case '"':
                   if ($in_double_quotes)
                       $in_double_quotes = false;
                   else
                       $in_double_quotes = true;

                break;

                case "'":
                  if ($in_single_quotes)
                      $in_single_quotes = false;
                  else
                      $in_single_quotes = true;

                break;

                case '/':
                    if ($is_open && !$in_double_quotes && !$in_single_quotes)
                    {
                        $is_close  = true;
                        $is_open   = false;
                        $grab_open = false;
                    }

                    break;

                case ' ':
                    if ($is_open)
                        $grab_open = false;
                    else
                        $stripped++;

                    break;

                case '>':
                    if ($is_open)
                    {
                        $is_open   = false;
                        $grab_open = false;
                        array_push($tags, $tag);
                        $tag = "";
                    }
                    else if ($is_close)
                    {
                        $is_close = false;
                        array_pop($tags);
                        $tag = "";
                    }

                    break;

                default:
                    if ($grab_open || $is_close)
                        $tag .= $symbol;

                    if (!$is_open && !$is_close)
                        $stripped++;
            }

            $i++;
        }

        while ($tags)
            $result .= "</".array_pop($tags).">";

        return $result;
    }
}
?>
