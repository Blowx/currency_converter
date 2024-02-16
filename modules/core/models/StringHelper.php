<?php

namespace application\modules\core\models;

class StringHelper
{
    /**
     * Splits string by specified delimiter and returns NOt empty values only
     *
     * @param string $text      String to be split
     * @param string $delimiter Splitting delimiter
     *
     * @return array
     */
    public static function split($text, $delimiter = ';')
    {
        $result = [];
        // trim initial string
        $text = trim($text ?? '');
        if ($text !== "") {
            // Split string to element
            if (empty($delimiter)) {
                $items = [$text];
            } else {
                $items = explode($delimiter, $text);
            }
            // Check for empty values
            foreach ($items as $item) {
                $item = trim($item);
                // return NOT empty values only
                if ($item !== '') {
                    $result[] = $item;
                }
            }
        }

        return $result;
    }

    /**
     * Returns JSON field value
     *
     * @param string $json    JSON to retrieve field value from
     * @param string $name    Field name to return value of
     * @param null   $default Default value to be returned in not found
     *
     * @return mixed|null
     */
    public static function jsonField($json, $name, $default = null)
    {
        $data = json_decode($json, true);
        if (is_array($data)) {
            return ArrayHelper::getValue($data, $name, $default);
        }

        return $default;
    }

    /**
     * Returns whether passed string seems to be json
     *
     * @param string $json JSON sting to be validated
     *
     * @return bool
     */
    public static function isJson($json)
    {
        $flag = false;
        if (is_string($json)) {
            json_decode($json, true);
            $flag = (json_last_error() == JSON_ERROR_NONE);
        }

        return $flag;
    }

    /**
     * Cleans up phone number leaving only numbers and initial +
     *
     * @param string $phone Phone to be cleaned up
     *
     * @return mixed|string
     */
    public static function cleanupPhone($phone)
    {
        $sign = '';
        if (substr(trim($phone), 0, 1) == '+') {
            $sign = '+';
        }
        $phone = preg_replace(
            '/[^0-9]/',
            '',
            $phone
        );

        return "{$sign}{$phone}";
    }

    /**
     * Tries to decode provided JSON string and return the result or default value
     *
     * @param ?string $json    JSON string to decode
     * @param null    $default Default value to return in case of error
     *
     * @return mixed|null
     */
    public static function jsonDecode(?string $json, $default = null)
    {
        $data = json_decode($json ?? '', true);
        if (null === $data) {
            $data = $default;
        }

        return $data;
    }

    /**
     * Adds value multiplied specified amount of times to the source string
     * and truncates it up to specified amount of characters if specified so
     *
     * @param string   $source    Source string to add value to
     * @param string   $value     Value to add
     * @param int|null $maxLength Maximal length of result string
     *
     * @return string
     */
    public static function lglue(string $source, string $value, int $maxLength): string
    {

        $repeat = ceil(($maxLength - strlen($source)) / strlen($value));
        $target = str_repeat($value, max(0, $repeat)) . $source;

        return substr($target, -$maxLength);
    }
}
