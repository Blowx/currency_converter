<?php

namespace application\modules\core\models;

class DataHelper
{
    /**
     * Replaces macros in specified mixed data
     *
     * @param mixed $data   Data to replace macros in
     * @param array $macros Macros array to be used
     *
     * @return array|mixed
     */
    public static function replace($data, array $macros)
    {
        switch (true) {
            case is_array($data):
                $data = ArrayHelper::replace($data, $macros);
                break;
            default:
        }

        return $data;
    }

    /**
     * casts specified value to integer
     *
     * @param mixed $value   Value to cast
     * @param ?int  $default Default value to be returned in case of failure
     *
     * @return int|null
     */
    public static function castInt($value, $default = null): ?int
    {
        switch (true) {
            case $value === null:
            case $value === 'null':
                $value = null;
                break;
            case is_int($value):
                break;
            case is_string($value):
            case is_bool($value):
            case is_float($value):
                $value = (int)$value;
                break;
            default:
                $value = $default;
        }

        return $value;
    }

    /**
     * Checks if specified value can be converted to integer
     * using castInt function above
     *
     * @param mixed $value     Value to be checked
     * @param bool  $allowNull Flag indicating whether null is considered as int
     *
     * @return bool
     */
    public static function isInt($value, $allowNull = true): bool
    {
        switch (true) {
            case $value === null:
            case $value === 'null':
                return $allowNull;
            case is_int($value):
            case is_string($value):
            case is_bool($value):
            case is_float($value):
                return true;
            default:
                return false;
        }
    }
}
