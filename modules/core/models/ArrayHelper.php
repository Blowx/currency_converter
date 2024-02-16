<?php

namespace application\modules\core\models;

use yii;

class ArrayHelper extends yii\helpers\ArrayHelper
{
    /**
     * Splits array string values by specified delimiter,
     * keeps non-scalar values and return not empty values only.
     *
     * @param array  $array     KEY=>VALUE array to split values for
     * @param string $delimiter Values delimiter to be used for splitting
     *
     * @return array
     */
    public static function splitValues(array $array, $delimiter = ';')
    {
        $result = [];
        foreach ($array as $key => $value) {
            // Split scalar values only
            if (is_scalar($value)) {
                $values = StringHelper::split($value, $delimiter);
            } else {
                $values = $value;
            }
            if (!empty($values)) {
                $result[$key] = $values;
            }
        }

        return $result;
    }

    /**
     * Casts array values using specified cast function
     *
     * @param array  $array    Array to cast values for
     * @param string $castFunc Cast function to be used
     *
     * @return array
     * @throws \Exception
     */
    public static function castValues(array $array, $castFunc = 'strval')
    {
        if (function_exists($castFunc)) {
            foreach ($array as $key => $value) {
                // Cast scalar values only
                if (is_scalar($value) || is_null($value)) {
                    $array[$key] = $castFunc($value);
                }
            }

            return $array;
        } else {
            throw new \Exception("Invalid cast function: {$castFunc}");
        }
    }

    /**
     * Returns unique array values only
     *
     * @param array $array Array to return unique values for
     *
     * @return array
     */
    public static function uniqueValues(array $array)
    {
        if (!empty($array)) {
            $array = array_values(array_unique($array, SORT_REGULAR));
        }

        return $array;
    }

    /**
     * Returns array containing Key, Value pair one after another from given array
     *
     * @param array $array Associative array to convert
     *
     * @return array
     */
    public static function combinePairs(array $array)
    {
        $result = [];
        foreach ($array as $key => $value) {
            $result[] = $key;
            $result[] = $value;
        }

        return $result;
    }

    /**
     * Goes through all array values and replace macros
     *
     * @param array $source Array of data to replace macros in
     * @param array $macros Macros to be replaces
     *
     * @return array
     */
    public static function replace(array $source, array $macros)
    {
        $result = [];
        foreach ($source as $key => $data) {
            $result[$key] = DataHelper::replace($data, $macros);
        }

        return $result;
    }

    /**
     * Replaces value in array by specified path
     *
     * @param array $source Source array to replace value in
     * @param array $path   Array of sequential keys to find value by
     * @param mixed $value  Value to replace
     */
    public static function replaceRecursive(array &$source, array $path, $value)
    {
        if (count($path) > 0) {
            $find = array_shift($path);
            $last = (count($path) <= 0);
            $done = false;
            foreach ($source as $key => &$data) {
                if ($find !== $key) {
                    continue;
                }
                $done = true;
                if ($last) {
                    $source[$find] = $value;
                } elseif (is_array($data)) {
                    ArrayHelper::replaceRecursive($data, $path, $value);
                } else {
                    break;
                }
                $done = false;
                break;
            }
            if (!$done) {
                ArrayHelper::replaceRecursive($source, $path, $value);
            }
        }
    }

    /**
     * Implodes
     *
     * @param array $array  KEY => VALUE array to be search in
     * @param array $values List of values to return keys for
     *
     * @return array
     */
    public static function valueKeys(array $array, array $values)
    {
        $data = [];
        foreach ($values as $value) {
            $keys = array_keys($array, $value);
            $data = array_merge($data, $keys);
        }

        return $data;
    }

    /**
     * Join array elements with a string and do type cast specified
     *
     * @param string $delimiter Values delimiter
     * @param array  $array     Array of values to be implode
     * @param string $castFunc  Type cast function
     *
     * @return string
     * @throws \Exception
     */
    public static function castImplode($delimiter, array $array, $castFunc = 'strval')
    {
        if (function_exists($castFunc)) {
            $str = '';
            $del = '';
            foreach ($array as $value) {
                // Cast scalar values only
                if (is_scalar($value) || is_null($value)) {
                    $str .= $del . $castFunc($value);
                    $del = $delimiter;
                }
            }

            return $str;
        } else {
            throw new \Exception("Invalid cast function: {$castFunc}");
        }
    }

    /**
     * Json decode with default value
     *
     * @param string $data
     * @param array  $default
     *
     * @return array|mixed
     */
    public static function jsonDecode(string $data, $default = [])
    {
        $data = json_decode($data);
        if (is_array($data)) {
            return $data;
        }

        return $default;
    }

    /**
     * Implodes provided array into string
     * separating values by delimiter and
     * return default value if empty result
     *
     * @param string $delimiter Delimiter to use
     * @param array  $data      Values array
     * @param string $default   Default value to return in case of empty result
     *
     * @return string
     */

    public static function implode(array $data, string $delimiter = ',', $default = ''): string
    {
        $result = implode($delimiter, $data);
        if (empty($result)) {
            $result = $default;
        }

        return $result;
    }
}
