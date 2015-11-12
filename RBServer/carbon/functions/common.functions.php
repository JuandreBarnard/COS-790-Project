<?php

require_once __DIR__ . '/../requests/requests.inc.php';
require_once __DIR__ . '/../functions/converters.functions.php';

/**
 * Credits to StackOverflow user: user2247350
 */
function getBrowserOS() {
    $server = Array(
        'HTTP_USER_AGENT' => Request::REQUIRED
    );

    $request = new ServerRequest();
    $server = $request->extract($server);
    $server = arrayToJSONObject($server);
    

    $userAgent = $server->HTTP_USER_AGENT;
    $browser = "Unknown Browser";
    $OS = "Unknown OS Platform";

    // Get the Operating System Platform

    if (preg_match('/windows|win32/i', $userAgent)) {

        $OS = 'Windows';

        if (preg_match('/windows nt 6.2/i', $userAgent)) {

            $OS .= " 8";
        } else if (preg_match('/windows nt 6.1/i', $userAgent)) {

            $OS .= " 7";
        } else if (preg_match('/windows nt 6.0/i', $userAgent)) {

            $OS .= " Vista";
        } else if (preg_match('/windows nt 5.2/i', $userAgent)) {

            $OS .= " Server 2003/XP x64";
        } else if (preg_match('/windows nt 5.1/i', $userAgent) || preg_match('/windows xp/i', $userAgent)) {

            $OS .= " XP";
        } else if (preg_match('/windows nt 5.0/i', $userAgent)) {

            $OS .= " 2000";
        } else if (preg_match('/windows me/i', $userAgent)) {

            $OS .= " ME";
        } else if (preg_match('/win98/i', $userAgent)) {

            $OS .= " 98";
        } else if (preg_match('/win95/i', $userAgent)) {

            $OS .= " 95";
        } else if (preg_match('/win16/i', $userAgent)) {

            $OS .= " 3.11";
        }
    } else if (preg_match('/macintosh|mac os x/i', $userAgent)) {

        $OS = 'Mac';

        if (preg_match('/macintosh/i', $userAgent)) {

            $OS .= " OS X";
        } else if (preg_match('/mac_powerpc/i', $userAgent)) {

            $OS .= " OS 9";
        }
    } else if (preg_match('/linux/i', $userAgent)) {

        $OS = "Linux";
    }

    // Override if matched

    if (preg_match('/iphone/i', $userAgent)) {

        $OS = "iPhone";
    } else if (preg_match('/android/i', $userAgent)) {

        $OS = "Android";
    } else if (preg_match('/blackberry/i', $userAgent)) {

        $OS = "BlackBerry";
    } else if (preg_match('/webos/i', $userAgent)) {

        $OS = "Mobile";
    } else if (preg_match('/ipod/i', $userAgent)) {

        $OS = "iPod";
    } else if (preg_match('/ipad/i', $userAgent)) {

        $OS = "iPad";
    }

    // Get the Browser

    if (preg_match('/msie/i', $userAgent) && !preg_match('/opera/i', $userAgent)) {

        $browser = "Internet Explorer";
    } else if (preg_match('/firefox/i', $userAgent)) {

        $browser = "Firefox";
    } else if (preg_match('/chrome/i', $userAgent)) {

        $browser = "Chrome";
    } else if (preg_match('/safari/i', $userAgent)) {

        $browser = "Safari";
    } else if (preg_match('/opera/i', $userAgent)) {

        $browser = "Opera";
    } else if (preg_match('/netscape/i', $userAgent)) {

        $browser = "Netscape";
    }

    // Override if matched

    if ($OS == "iPhone" || $OS == "Android" || $OS == "BlackBerry" || $OS == "Mobile" || $OS == "iPod" || $OS == "iPad") {

        if (preg_match('/mobile/i', $userAgent)) {

            $browser = "Handheld Browser";
        }
    }

    // Create a Data Array
    $returnData = [
        'browser' => $browser,
        'OS' => $OS,
    ];
    
    return arrayToJSONObject($returnData);
}

/**
 * Generates a random hashed and salted string.
 * @return type
 */
function generateRandomString($urlSafe = true, $length = 10){
    // Use date timestamp as salt.
    $rand = mt_rand();
    $salt = $rand.uniqid(); 
    
    $string = sha1($salt);
    $string = base64_encode($string);
    
    if($urlSafe){
        $string = makeUrlSafe($string);
    }
    
    $string = substr($string, 0, $length);
    
    return $string;
}

/**
 * Removes all characters that are not alphanumeric. Makes url string safe.
 * @param string $string String to be converted.
 * @return string Converted url safe string.
 */
function makeUrlSafe($string){
    return preg_replace("/[^a-zA-Z0-9._]/", "", $string);
}