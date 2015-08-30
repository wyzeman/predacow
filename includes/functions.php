<?php

function format_filesize($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    // Uncomment one of the following alternatives
    $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow)); 

    return round($bytes, $precision) . ' ' . $units[$pow];
}

function format_phone($phone) {

    $phone = preg_replace("/[^0-9]/", "", $phone);



    if (strlen($phone) == 7)
        return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);

    elseif (strlen($phone) == 10)
        return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
    else
        return $phone;
}

/**
 * Make the browser get redirected to an URL with a notice in a floating dialog.
 *
 * @param <type> $url URL for redirection
 * @param <type> $notice Notice to display
 */
function die_notice($url, $notice) {
    if (strpos($url, "?") === false)
        die(header("Location: $url?notice=" . base64_encode($notice)));
    else
        die(header("Location: $url&notice=" . base64_encode($notice)));
}

function die_warning($url, $warning) {
    if (strpos($url, "?") === false)
        die(header("Location: $url?warning=" . base64_encode($warning)));
    else
        die(header("Location: $url&warning=" . base64_encode($warning)));
}


/**
 * Redirect user to a specific URL
 *
 * @param <type> $url Redirect to this URL
 */
function die_redirect($url) {

    die(header("Location: $url"));
}

function sort_array($orig, $key, $direction) {

    function build_sorter($key) {
        return function ($a, $b) use ($key) {
            $v = strnatcmp($a[$key], $b[$key]);
            //        print "A:".$a[$key].", B:".$b[$key]." V:$v<br/>";
            return $v;
        };
    }

    usort($orig, build_sorter($key));
    if ($direction == "DESC") {

        $new = array();
        for ($i = count($orig) - 1; $i >= 0; $i--) {
            $new[] = $orig[$i];
        }
        return $new;
    }

    return $orig;
}

function block_td_overflow($text, $max) {
    $new_text = "";
    $count = 0;
    for ($i = 0; $i < strlen($text); $i++) {
        $new_text .= $text[$i];
        if ($text[$i] == " ") {
            $count = 0;
        } else if ($count++ == $max) {
            $new_text = " ";
            $count = 0;
        }
    }
    return $new_text;
}

function my_money_format($val) {
    
    $val = "" . $val; // string conversion

    if (strpos($val,",") === false) {
        $v = explode(".", $val);
        if (count($v) == 1)
            return ($val . ".00");

        $d = $v[0];
        $c = $v[1];
        if (strlen($c) > 2)
            $c = substr($c, 0, 2);
        if (strlen($c) == 1)
            $c .= "0";

        return $d . "." . $c;
    } else {
        $v = explode(",", $val);
        if (count($v) == 1)
            return ($val . ".00");

        $d = $v[0];
        $c = $v[1];
        if (strlen($c) > 2)
            $c = substr($c, 0, 2);
        if (strlen($c) == 1)
            $c .= "0";

        return $d . "." . $c;
    }
}

function startsWith($haystack, $needle) {
    return $needle === "" || strpos($haystack, $needle) === 0;
}

//this function return a formated value of the time elapsed
function elapsed_time($elapsed_time, $short_values = false) {

    $min=60;
    $hour=$min*$min;
    $day=$hour*24;
    $week=$day*7;


    if ($elapsed_time == 0) {

        $elapsed_time = 1;
    }

    if ($short_values == true) {
        if ($elapsed_time < $min) {
            $elapsed_time = $elapsed_time."s";
        } elseif ($elapsed_time < $hour) {
            $elapsed_time = (int)($elapsed_time/$min)."m";
        } elseif ($elapsed_time < $day) {
            $elapsed_time = (int)($elapsed_time/$hour)."h";
        } elseif ($elapsed_time < $week) {
            $elapsed_time = (int)($elapsed_time/$day)."d";
        } elseif ($elapsed_time > $week) {
            $elapsed_time = (int)($elapsed_time/$week)."w";
        }

    } else {

        if ($elapsed_time < $min) {
            if ($elapsed_time == 1) {
                $elapsed_time = $elapsed_time." ".T_("second");
            } else {
                $elapsed_time = $elapsed_time." ".T_("seconds");
            }
        } elseif ($elapsed_time < $hour) {
            if ((int)($elapsed_time/$min) == 1) {
                $elapsed_time = (int)($elapsed_time/$min)." ".T_("minute");
            } else {
                $elapsed_time = (int)($elapsed_time/$min)." ".T_("minutes");
            }
        } elseif ($elapsed_time < $day) {
            if ((int)($elapsed_time/$hour) == 1) {
                $elapsed_time = (int)($elapsed_time/$hour)." ".T_("hour");
            } else {
                $elapsed_time = (int)($elapsed_time/$hour)." ".T_("hours");
            }
        } elseif ($elapsed_time < $week) {
            if ((int)($elapsed_time/$day) == 1) {
                $elapsed_time = (int)($elapsed_time/$day)." ".T_("day");
            } else {
                $elapsed_time = (int)($elapsed_time/$day)." ".T_("days");
            }
        } elseif ($elapsed_time > $week) {
            if ((int)($elapsed_time/$week) == 1) {
                $elapsed_time = (int)($elapsed_time/$week)." ".T_("week");
            } else {
                $elapsed_time = (int)($elapsed_time/$week)." ".T_("weeks");
            }
        }
    }

    return($elapsed_time);
}


function recursive_rmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir") recursive_rmdir($dir."/".$object); else unlink($dir."/".$object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}


function lsfile($dir)
{
    $x=0;
    $ls=opendir($dir);
    while(false !== ($lsdir = readdir($ls)))
    {
        if(!is_dir($dir."/".$lsdir))
        {
            $flist[$x]=$lsdir;
            $x++;
        }
    }
//	if (is_array($flist))
//		{
//		sort($flist);
//		}

    return($flist);
}




function read_file($file)
{
    @$fid=fopen($file,"r");
    $page="";
    if ($fid)
    {
        while (!feof($fid))
        {
            $page=$page.fread($fid,1024);
        }
        fclose($fid);
    }
    else
    {
        $page=0;
    }
    return($page);
}

function write_file($file,$content)
{
    @$fid=fopen($file,"w");
    if ($fid)
    {
        fwrite($fid,$content);
    }
    fclose($fid);
}
