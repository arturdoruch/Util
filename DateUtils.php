<?php
/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */

namespace ArturDoruch\Util;

class DateUtils
{
    private static $monthNumber = array(
        '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'
    );

    private static $monthString = array(
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    );

    /**
     * Converts month name from string into integer representation.
     *
     * @param string $month Month name. Can be short version like "Jan" or full name like: "January".
     *
     * @return int|null
     */
    public static function monthToNumber($month)
    {
        $month = ucfirst( strtolower( substr($month, 0, 3) ) );
        foreach (static::$monthString as $i => $monthString) {
            if ($monthString == $month) {
                return (int) static::$monthNumber[$i];
            }
        }

        return null;
    }

    /**
     * Converts month number into string representation.
     *
     * @param number $month
     *
     * @return string|null
     */
    public static function monthToString($month)
    {
        foreach (static::$monthNumber as $i => $monthNumber) {
            if ($monthNumber == $month) {
                return static::$monthString[$i];
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
