<?php

namespace application\modules\rest\models\Entity;

use application\modules\rest\models;
use application\modules\rest\models\Defines;

class Helper
{
    /**
     * Updates field to needed
     *
     * @param models\MySqlEntity $entity Entity that will be updated
     * @param string             $field  Field that will be updated
     * @param string             $value  Value that will be updatet in Entity
     */
    public static function updateField(models\MySqlEntity $entity, $field, $value)
    {
        if (array_key_exists($field, $entity->attributes)) {
            $entity->$field = $value;
        }
    }

    /**
     * Updates ONLY ALLOWED entity attributes taken values from data array provided
     *
     * @param models\MySqlEntity $entity Entity that will be updated
     * @param array              $data   Array of fields that would be updated
     *
     * @return bool
     */
    public static function update(models\MySqlEntity $entity, array $data): bool
    {
        $done = false;
        // Filter data by entity attributes
        $attr = array_intersect_key($data, $entity->attributes);
        // Attributes to skip updating
        $skip = array_diff(array_keys($attr), $entity->allowedParamsToUpdate());
        foreach ($attr as $name => $value) {
            if (in_array($name, $skip)) {
                continue;
            }
//            if (in_array($name, Defines\Request\Parameter::timeStampFields())) {
//                $value = date("Y-m-d H:i:s", $value);
//            }
            $done = true;
            $entity->setAttribute($name, $value);
        }

        return $done;
    }

    /**
     * Returns string, that contains error messages
     *
     * @param array  $errors    Array or errors, that will be transformed to string
     * @param string $separator A string that will separate the errors
     *
     * @return string
     */
    public static function errorsToString(array $errors, $separator = ' ')
    {
        $msg = '';
        foreach ($errors as $error) {
            $msg .= implode(", ", array_values($error)) . $separator;
        }

        return $msg;
    }

    /**
     * This method is used to change bit/bits for a given bitmask. Retrieves changed bitmask
     *
     * @param int  $bitmask Bitmask to change bit for
     * @param int  $bit     Bit/bits which will be changed
     * @param bool $status  Bit status: TRUE - bit/bits will be switched ON otherwise they will be switched OFF
     *
     * @return int
     */
    public static function changeBit($bitmask, $bit, $status)
    {
        switch ($status) {
            case true:
                $bitmask |= $bit;
                break;
            case false:
                $bitmask &= ~$bit;
                break;
            default:
        }

        return $bitmask;
    }

    /**
     * Update user's field flag when it needed
     *
     * @param $init      - flags parameter from user
     * @param $value     - value of flag from request
     * @param $parameter - flag value
     *
     * @return mixed
     */
    public static function updateFlag($init, $value, $parameter)
    {
        if ($value) {
            return self::add($init, $parameter);
        } else {
            return self::remove($init, $parameter);
        }
    }

    /**
     * Check if flag checked or not
     *
     * @param int $init user's initial flags
     * @param int $flag Flag's value for update
     *
     * @return integer
     */
    public static function checkFlag($init, $flag)
    {
        if ($init & $flag) {
            return 1;
        }

        return 0;
    }

    /**
     * Add flag's value to user's flags field
     *
     * @param int $init user's initial flags
     * @param int $flag Flag's value for update
     *
     * @return mixed
     */
    public static function add($init, $flag)
    {
        return $init | $flag;
    }

    /**
     * Remove flag's value from user's flags field
     *
     * @param int $init user's initial flags
     * @param int $flag Flag's value for update
     *
     * @return mixed
     */
    public static function remove($init, $flag)
    {
        return $init & ~$flag;
    }

    /**
     * Check if Entity's param was changed or not
     *
     * @param models\MySqlEntity $entity
     * @param                    $oldParamName
     * @param                    $newParamValue
     *
     * @return bool
     */
    public static function checkEntityChanged(models\MySqlEntity $entity, $oldParamName, $newParamValue)
    {
        return ($entity->$oldParamName != $newParamValue);
    }
}
