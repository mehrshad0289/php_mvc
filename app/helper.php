<?php

function redirect($page, $seesion = [])
{
    $_SESSION[key($seesion)] = $seesion[key($seesion)];

    header("Location:" . URL_ROOT . $page);
    exit;
}

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}
if (!function_exists('generateFileName')) {
    function generateFileName($name)
    {
        // دریافت تاریخ و زمان کنونی
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $hour = date('H');
        $minute = date('i');
        $second = date('s');
        $microsecond = sprintf('%06d', (int)(microtime(true) * 1000000) % 1000000);

        // ترکیب تاریخ، زمان و نام فایل
        return $year . '_' . $month . '_' . $day . '_' . $hour . '_' . $minute . '_' . $second . '_' . $microsecond . '_' . $name;
    }
}

