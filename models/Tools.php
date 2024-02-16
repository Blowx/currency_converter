<?php

namespace application\models;

/**
 * Class Tools.php
 **/
class Tools
{
    /**
     * Returns value by Key from data array if any or default value otherwise
     *
     * @param mixed  $aData    Array of data to find value in
     * @param string $sKey     Key of data to find
     * @param mixed  $mDefault Default value to be returned
     *
     * @return  mixed
     */
    final public static function getValue($aData, $sKey, $mDefault = null)
    {
        if (is_array($aData) && isset($aData[$sKey])) {
            return $aData[$sKey];
        }

        return $mDefault;
    }
}
