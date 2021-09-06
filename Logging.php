<?php

// Configs
define("HOST", "localhost");
define("USER", "root");
define("PASS", "123456789");
define("NAME", "stajdegerlendirme");

$db = "";
// Connect to database
try {
    $db = new PDO("mysql:host=" . HOST . ";dbname=" . NAME . ";charset=utf8", "" . USER . "", "" . PASS . "");
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
//    echo $e->getMessage();
}

// Simple function to handle PDO prepared statements
function sql($db, $q, $params, $return)
{
    //$db = $GLOBALS['db'];
    // Prepare statement
    $stmt = $db->prepare($q);
    // Execute statement
    $stmt->execute($params);

    // Decide whether to return the rows themselves, or just count the rows
    if ($return == "rows") {
        return $stmt->fetchAll();
    } else if ($return == "count") {
        return $stmt->rowCount();
    } else if ($return == "id") {
        return $db->lastInsertId();
    }
}

/*
$rows = sql($db, "SELECT * FROM icerik WHERE ID = ?", array(), "rows");
// Get results

foreach($rows as $row) {
   // echo $row['METIN'].' '.$row['KATEGORIID']; //etc...
}
*/

// With INSERT
// Call function
//$rows = sql($db, "INSERT INTO icerik (KATEGORIID, BASLIK, SIRA, METIN) VALUES (?, ?, ?, ?)", array(20,"başlık" , 3,"dene88me"),"");

// With UPDATE
// Call function
//sql($db, "UPDATE icerik SET BASLIK = ? WHERE ID = ?", array("B11AAASLIK", 7),"");

// With DELETE
// Call function
//sql($db, "DELETE FROM table WHERE id = ?", array($id));


class UserInfo
{

    private static function get_user_agent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public static function get_ip()
    {
        $mainIp = '';
        if (getenv('HTTP_CLIENT_IP'))
            $mainIp = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $mainIp = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $mainIp = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $mainIp = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $mainIp = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $mainIp = getenv('REMOTE_ADDR');
        else
            $mainIp = 'UNKNOWN';
        return $mainIp;
    }

    public static function get_os()
    {

        $user_agent = self::get_user_agent();
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

    public static function get_browser()
    {

        $user_agent = self::get_user_agent();

        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/Trident/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/edge/i' => 'Edge',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/ubrowser/i' => 'UC Browser',
            '/mobile/i' => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }

        }

        return $browser;

    }

    public static function get_device()
    {

        $tablet_browser = 0;
        $mobile_browser = 0;

        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $tablet_browser++;
        }

        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }

        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }

        $mobile_ua = strtolower(substr(self::get_user_agent(), 0, 4));
        $mobile_agents = array(
            'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
            'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
            'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
            'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
            'newt', 'noki', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
            'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
            'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
            'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
            'wapr', 'webc', 'winw', 'winw', 'xda ', 'xda-');

        if (in_array($mobile_ua, $mobile_agents)) {
            $mobile_browser++;
        }

        if (strpos(strtolower(self::get_user_agent()), 'opera mini') > 0) {
            $mobile_browser++;
            //Check for tablets on opera mini alternative headers
            $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
                $tablet_browser++;
            }
        }

        if ($tablet_browser > 0) {
            // do something for tablet devices
            return 'Tablet';
        } else if ($mobile_browser > 0) {
            // do something for mobile devices
            return 'Telefon';
        } else {
            // do something for everything else
            return 'Bilgisayar';
        }
    }

}


function LogKaydet($kullanici_id, $islem_turu)
{
    global $db;

    $user_info = new UserInfo;
//    $cihaz_ip = $user_info->get_ip();
    date_default_timezone_set("Europe/Istanbul");
    $date = date('Y-m-d H:i:s');

    $cihaz_ip  =  file_get_contents('http://api64.ipify.org');
    $cihaz_tur = $user_info->get_device();
    $cihaz_isletim_sistemi = $user_info->get_os();
    $cihaz_tarayici = $user_info->get_browser();

    try {
        sql($db, "INSERT INTO log_kayit (kullanici_id, cihaz_ip, cihaz_tur, 
                            cihaz_isletim_sistemi, cihaz_tarayici, islem_turu, islem_tarihi)
                            VALUES (?, ?, ?, ?, ?, ?, ?)", array($kullanici_id, $cihaz_ip, $cihaz_tur,
            $cihaz_isletim_sistemi, $cihaz_tarayici, $islem_turu, $date), "");

        return true;
    } catch (Exception $e) {
        return false;
        //echo 'Yakalanan olağandışılık: ', $e->getMessage(), "\n";
    }
}


?>