<?php

namespace ArturDoruch\Util;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class DateUtils
{
    private static $months = array(
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    );

    /**
     * Converts month string into integer representation.
     *
     * @param string $month      Month name. Can be short version like "Jan" or full name like: "January".
     * @param bool   $leaveZero  If true month number will be preceded by with "0".
     *                           Otherwise number will be of integer type.
     *
     * @return number|int|null
     */
    public static function monthToNumber($month, $leaveZero = false)
    {
        $month = trim($month);
        foreach (static::$months as $number => $string) {
            if (stripos($string, $month) === 0) {
                return $leaveZero === false ? (int) $number : $number;
            }
        }

        return null;
    }

    /**
     * Converts month number into string representation.
     *
     * @param number $month
     * @param bool   $longName If false, month name will have 3 characters long, otherwise full length.
     *
     * @return string|null
     */
    public static function monthToString($month, $longName = false)
    {
        foreach (static::$months as $number => $string) {
            if ((int) $number === (int) $month) {
                return $longName === true ? $string : substr($string, 0, 3);
            }
        }

        return null;
    }

    /**
     * Compare date time in sql format with current date.
     * Use DateInterval::format("%a") to get different time in days.
     * List format parameters find on: http://php.net/manual/en/dateinterval.format.php
     *
     * @param string $dateTime Date time in sql format: YYYY-MM-DD HH:MM:SS.
     *
     * @return \DateInterval
     */
    public static function compareDateTime($dateTime)
    {
        $dateTimeToCompare = new \DateTime($dateTime);

        return $dateTimeToCompare->diff( new \DateTime() );
    }

}
