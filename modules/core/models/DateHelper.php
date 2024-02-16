<?php

namespace application\modules\core\models;

class DateHelper
{
    /**
     * Returns day of week for specified timestamp
     *
     * @param integer $timestamp Timestamp to use
     *
     * @return int
     */
    public static function dayOfW($timestamp)
    {
        return (int)date('N', $timestamp);
    }

    /**
     * Returns day of month for specified timestamp
     *
     * @param integer $timestamp Timestamp to use
     *
     * @return int
     */
    public static function dayOfM($timestamp)
    {
        return (int)date('d', $timestamp);
    }

    /**
     * Returns timestamp of month first day
     *
     * @param integer $timestamp Timestamp to use
     *
     * @return int
     */
    public static function monthS($timestamp)
    {
        return strtotime(date('Y-m-01', $timestamp));
    }

    /**
     * Returns timestamp of month last day
     *
     * @param integer $timestamp Timestamp to use
     *
     * @return int
     */
    public static function monthE($timestamp)
    {
        return strtotime(date('Y-m-t', $timestamp));
    }

    /**
     * Returns week of year for specified timestamp
     *
     * @param integer $timestamp Timestamp to use
     *
     * @return int
     */
    public static function weekOfY($timestamp)
    {
        $week = (int)date('W', $timestamp);
        // Last days of year may be related to 1st week of next year
        if (1 == $week) {
            $monS = DateHelper::monthS($timestamp);
            // Week of beginning of month always less than other month day
            if ((int)date('W', $monS) > $week) {
                // If it's bigger - it's end of year 53-th week
                $week = 53;
            }
        }

        return $week;
    }

    /**
     * Returns week of month for specified timestamp
     *
     * @param integer $timestamp Timestamp to use
     *
     * @return int
     */
    public static function weekOfM($timestamp)
    {
        $monS = DateHelper::monthS($timestamp);

        return DateHelper::weekOfY($timestamp) - DateHelper::weekOfY($monS) + 1;
    }

    /**
     * Returns difference in years for specified dates
     *
     * @param integer $date1 First timestamp
     * @param integer $date2 Second timestamp
     *
     * @return int
     */
    public static function diffYear($date1, $date2)
    {
        return (int)date('Y', $date1) - (int)date('Y', $date2);
    }

    /**
     * Returns month difference for specified timestamp
     *
     * @param integer $date1 First timestamp
     * @param integer $date2 Second timestamp
     *
     * @return int
     */
    public static function diffMons($date1, $date2)
    {
        $year = DateHelper::diffYear($date1, $date2);
        $from = (int)date('m', $date1);
        $till = (int)date('m', $date2);

        return $from - $till + 12 * $year;
    }

    /**
     * Returns weeks difference for specified timestamp
     *
     * @param integer $date1 First timestamp
     * @param integer $date2 Second timestamp
     *
     * @return int
     */
    public static function diffWeek($date1, $date2)
    {
        return (int)DateHelper::diffDays($date1, $date2) / 7;
    }

    /**
     * Returns days difference for specified timestamps
     *
     * @param integer $date1 First timestamp
     * @param integer $date2 Second timestamp
     *
     * @return float
     */
    public static function diffDays($date1, $date2)
    {
        return floor(($date1 - $date2) / (60 * 60 * 24));
    }

    /**
     * Returns hours difference for specified timestamps
     *
     * @param integer $date1 First timestamp
     * @param integer $date2 Second timestamp
     *
     * @return float
     */
    public static function diffHours($date1, $date2)
    {
        return floor(($date1 - $date2) / 60 / 60);
    }

    /**
     * Returns minutes difference for specified timestamps
     *
     * @param integer $date1 First timestamp
     * @param integer $date2 Second timestamp
     *
     * @return float
     */
    public static function diffMins($date1, $date2)
    {
        return floor(($date1 - $date2) / 60);
    }

    /**
     * Returns amount of days till first working day for specified timestamp
     *
     * @param integer $time Timestamp to use
     * @param boolean $back Flag indicating whether of shift should be done backward
     *
     * @return int|mixed
     */
    public static function weekendShift($time, $back = false)
    {
        $weekD = DateHelper::dayOfW($time);
        $shift = max(0, $weekD - 5);
        if ($shift && !$back) {
            $shift = 3 - $shift;
        }

        return $shift;
    }

    /**
     * Returns whether specified timestamp is weekend
     *
     * @param integer $timestamp Timestamp to use
     *
     * @return bool
     */
    public static function isWeekend($timestamp)
    {
        return (DateHelper::dayOfW($timestamp) > 5);
    }
}
