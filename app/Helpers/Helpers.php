<?php

use voku\helper\ASCII;

function dd($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

function route($name, $params = [])
{
    $baseUrl = rtrim($_ENV['APP_URL'], '/') . '/';
    $url = $baseUrl . trim($name, '/');

    if (!empty($params)) {
        $url .= '/' . implode('/', array_map('urlencode', $params));
    }

    return $url;
}



function createSlug($string)
{
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
}

function set_timezone()
{
    date_default_timezone_set($_ENV['TIMEZONE'] ?: 'UTC');
}

function asset($path)
{
    return $_ENV['APP_URL'] . ltrim($path, '/');
}

function start_session()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function createUID($full_name, $dob, $existingUIDs = [])
{
    // Xóa dấu tiếng Việt và chuyển tên thành ASCII
    $fullName = iconv('UTF-8', 'ASCII//TRANSLIT', $full_name);

    // Tách họ và tên, lấy phần tên chính
    $nameParts = explode(' ', $fullName);
    $lastName = strtolower(array_pop($nameParts)); // Tên chính (viết thường)

    // Lấy ký tự đầu của các phần còn lại
    $initials = '';
    foreach ($nameParts as $part) {
        $initials .= strtolower(substr($part, 0, 1));
    }

    // Chuyển ngày sinh thành năm
    $dobYear = date('Y', strtotime($dob));

    // Tạo chuỗi cơ bản
    $baseUID = $lastName . $initials . $dobYear;

    // Tạo chuỗi duy nhất bổ sung
    $uniquePart = substr(uniqid(), -4); // Lấy 4 ký tự cuối của chuỗi ngẫu nhiên

    // Gắn chuỗi duy nhất vào UID
    $uid = $baseUID . $uniquePart;

    // Đảm bảo không trùng với UID đã tồn tại
    while (!empty($existingUIDs) && in_array($uid, $existingUIDs)) {
        $uniquePart = substr(uniqid(), -4); // Tạo lại chuỗi duy nhất
        $uid = $baseUID . $uniquePart;
    }

    return $uid;
}

function formattedDate($date, $format = 'd/m/Y H:i:s')
{
    return date($format, strtotime($date));
}

function get($key, $default = null)
{
    return $_GET[$key] ?? $default;
}

function isIpInRange($ip, $range)
{
    list($subnet, $bits) = explode('/', $range);
    $ip = ip2long($ip);
    $subnet = ip2long($subnet);
    $bits = ~((1 << (32 - $bits)) - 1);
    return ($ip & $bits) == ($subnet & $bits);
}

function session($key, $default = null)
{
    return $_SESSION[$key] ?? $default;
}

function session_put($key, $value)
{
    $_SESSION[$key] = $value;
}

function session_forget($key)
{
    unset($_SESSION[$key]);
}

function post($key, $default = null)
{
    return $_POST[$key] ?? $default;
}

function getFile($key)
{
    return $_FILES[$key] ?? null;
}
