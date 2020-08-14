<?php

/**
* Get previous years associative array from given number
* @param year int
* @return true/false
*/
function getLastYearsArray($_years=30)
{
    $years_array = array();
    $year = date('Y');
    $max = $year - $_years;
    $min = $year;
    for( $i=$min; $i>$max; $i-- ) {
        $years_array[$i] = $i;
    }
    return $years_array;
}

/**
* Get next years associative array from given number
* @param year int
* @return true/false
*/
function getNextYearsArray($_years=30)
{
    $years_array = array();
    $year = date('Y');
    $max = $year + $_years;
    $min = $year;
    for( $i=$min; $i<$max; $i++ ) {
        $years_array[$i] = $i;
    }
    return $years_array;
}


/**
* Check if is serialized
* @param string
* @return true/false
*/
function is_serialized($value, &$result = null)
{
    // Bit of a give away this one
    if (!is_string($value))
    {
        return false;
    }

    // Serialized false, return true. unserialize() returns false on an
    // invalid string or it could return false if the string is serialized
    // false, eliminate that possibility.
    if ($value === 'b:0;')
    {
        $result = false;
        return true;
    }

    $length = strlen($value);
    $end    = '';

    switch ($value[0])
    {
        case 's':
            if ($value[$length - 2] !== '"')
            {
                return false;
            }
        case 'b':
        case 'i':
        case 'd':
            // This looks odd but it is quicker than isset()ing
            $end .= ';';
        case 'a':
        case 'O':
            $end .= '}';

            if ($value[1] !== ':')
            {
                return false;
            }

            switch ($value[2])
            {
                case 0:
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                case 7:
                case 8:
                case 9:
                break;

                default:
                    return false;
            }
        case 'N':
            $end .= ';';

            if ($value[$length - 1] !== $end[0])
            {
                return false;
            }
        break;

        default:
            return false;
    }

    if (($result = @unserialize($value)) === false)
    {
        $result = null;
        return false;
    }
    return true;
}

/**
* Get random unique alphanumeric string
* @param string length (default 10)
* @return string
*/
function get_rand_txn_id($length = 10) {

    $randstring = '';
    $string_array = array_merge(range(0, 9), range('a', 'z'), range('A', 'Zå'));

    for ($i = 0; $i < $length; $i++) {
        $randstring .= $string_array[array_rand($string_array)];
    }

    return $randstring;
}


/**
* Get time formated
*
* @return string
*/
function current_time_formated() {
    $now = Carbon::now();
    return $now;
}

/**
* Get user ip address
*
* @param  var  $string
* @return ip addres
*/
function get_client_ip_server() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

/**
* Get browser and os info
*
* @param  var  $string
* @return ojbect
*/
function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $version = "";
    $ub = "";

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'version' => $version,
        'platform' => getOS(),
        'pattern' => $pattern
    );
}

/**
* Get OS info
*
* @param  var  $string
* @return ojbect
*/
function getOS() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    return $os_platform;
}

/**
* Get Browser info
*
* @param  var  $string
* @return ojbect
*/
function getUserBrowser() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $browser = "Unknown Browser";
    if (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false)) {
        return "Internet Explorer";
    }
    $browser_array = array(
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );

    //echo "<pre>";print_r($user_agent); die;

    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }
    return $browser;
}

/**
 * Return path to backend resources
 */
function backend_assets_directory($path = '') {

    if( is_ssl() ) {

        return secure_asset("/backend{$path}");

    }

    return asset("/backend{$path}"); // for dev only


}

/**
 * Return path to frontend resources
 */
function frontend_assets_directory($path = '') {

    if( is_ssl() ) {
        return secure_asset("/frontend{$path}");
    }

    return asset("/frontend{$path}"); // for dev only

}

/**
 * Return path to plugins resources
 */
function plugins_directory($path = '') {

    if( is_ssl() ) {
        return secure_asset("/plugins{$path}");
    }

    return asset("/plugins{$path}"); // for dev only


}

/**
 * Return path to images resources
 */
function images_directory($path = '') {

    if( is_ssl() ) {
        return secure_asset("/images{$path}");
    }

    return asset("/images{$path}"); // for dev only
}

/**
 * @return [url] path to logo.png
 */
function get_logo() {
    return images_directory("/logo.png");
}

/**
 * @return [url] path to logo.png
 */
function get_dark_logo() {
    return images_directory("/logo-dark.png");
}

/**
 * @return [url] path to favicon.ico
 */
function get_favicon() {
    return images_directory("/favicon.ico");
}

/**
 * Return path to uploads resources
 */
function uploads_directory($path = '') {

    if( is_ssl() ) {
        return secure_asset("/uploads{$path}");
    }

    return asset("/uploads{$path}"); // for dev only

}

/**
 * @param  $height
 * @param  $width
 * @return [dummy_image_url] url
 */
function get_dummy_image_url($height='1000', $width='600') {
    return "http://i.pravatar.cc/{$height}x{$width}";
}

/**
 * @return mixed string
 */
function get_custom_hash() {
    $length = 10;
    $keyspace = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }

    return Hash::make($str);
}

/**
 * Get dummy content
 * @return Mixed HTML
 */
function get_content() {
    return "
        <h1>Lorem ipsum dolor</h1><br /><br />
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, <em>quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</em> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><br /><br />
        <h2>Lorem ipsum dolor</h2><br /><br />
        <p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</strong> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><ul><li>Lorem ipsum dolor sit amet</li><li>consectetur adipiscing elit</li></ul><h3>Lorem ipsum dolor</h3><ol><li>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</li><li>Ut enim ad minim veniam</li></ol><h4>Lorem ipsum dolor</h4><br /><br />
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><br />
        ";
}

/**
 * Create anchor link
 * @param  str $text
 * @param  str $url
 * @param  array $classes
 * @return Mixed html anchor tag
 */
function get_html_anchor($text='Button', $url='http://google.com.pk/', $classes=[],) {
    return "<a title='{$text}' href='{$url}' class='". implode(" ",$classes); ."'>{$text}</a>";
}

/**
* Convert number into Words
*
* @param  var  $int
* @return english words from given number
*/
function number_to_words($number) {
    $hyphen      = ' ';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}


/**
* Get content via curl
* @param  var  $url
* @return mixed data
*/
function curl_get_contents($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
