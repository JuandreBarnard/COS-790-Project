<?php

define("SECOND", 1);
define("MINUTE", 60);
define("HOUR", 60);
define("DAY", 24);
define("WEEK", 7);
define("MONTH", 52 / 12);
define("YEAR", 12);

/**
 * Converts a JSON string to a JSON Object.
 * @param string $string String to be converted.
 * @return Object Converted object.
 */
function JSONStringToJSONObject($string) {
    return json_decode($string);
}

/**
 * Converts an array to a JSON Object.
 * @param array $arr Array to be converted.
 * @return Object Converted object.
 */
function arrayToJSONObject(Array $arr) {
    return json_decode(json_encode($arr));
}

/**
 * Converts an array to a JSON String.
 * @param array $arr Array to be converted.
 * @return Object Converted object.
 */
function arrayToJSONString(Array $arr) {
    return json_encode($arr);
}

/**
 * Converts an array to JSON Pretty String.
 * @param array $arr Array to be converted.
 * @return Object Converted object.
 */
function arrayToJSONPrettyString(Array $arr) {
    return json_encode($arr, JSON_PRETTY_PRINT);
}

/**
 * Converts DataTime to AgoTime format.
 * @param DataTeime $timestamp DateTime timestamp.
 * @param string $prefix Prefix string.
 * @param string $postfix Postfix string.
 * @return string Formatted ago time string.
 */
function timestampToAgoTime($timestamp, $prefix, $postfix) {
    date_default_timezone_set('Africa/Johannesburg');
    $seconds_ago = time() - strtotime($timestamp);

    $intervals = array(
        "year" => SECOND * MINUTE * HOUR * DAY * WEEK * MONTH * YEAR,
        "month" => SECOND * MINUTE * HOUR * DAY * WEEK * MONTH,
        "week" => SECOND * MINUTE * HOUR * DAY * WEEK,
        "day" => SECOND * MINUTE * HOUR * DAY,
        "hour" => SECOND * MINUTE * HOUR,
        "minute" => SECOND * MINUTE,
        "second" => SECOND
    );

    $last_interval = NULL;
    $last_value = NULL;
    $stop = false;

    foreach ($intervals as $interval => $value) {
        if ($stop == true) {
            $agoTime = (int) ($seconds_ago / $last_value);
            return $prefix . $agoTime . " " . $last_interval . ($agoTime > 1 ? "s" : "") . $postfix;
        }

        if ($seconds_ago >= $value) {
            $stop = true;
        }

        $last_interval = $interval;
        $last_value = $value;
    }
}
