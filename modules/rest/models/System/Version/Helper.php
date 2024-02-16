<?php

namespace application\modules\rest\models\System\Version;

use application\modules\rest\models\Defines;

/**
 * Class Helper
 *
 * @package application\modules\rest\models\System\Version
 */
class Helper
{
    /**
     * Returns current API version
     *
     * @return array
     */
    public static function getApiVersion()
    {
        return [
            'version' => Defines\Api\Version::CURRENT,
        ];
    }

    /**
     * Compares two versions and returns
     * -1 - if first less than second, 0 - if equal, 1 - if first grater
     *
     * @param string $one First version
     * @param string $two Second version
     */
    public static function compare($one, $two)
    {
        $one = explode('.', $one ?? '');
        $two = explode('.', $two ?? '');
        while (!empty($one) && !empty($two)) {
            $num1 = (int)array_shift($one);
            $num2 = (int)array_shift($two);
            switch (true) {
                case $num1 < $num2:
                    return -1;
                case $num1 > $num2:
                    return 1;
                case $num1 == $num2:
                default:
                    break;
            }
        }
        switch (true) {
            case empty($one) && empty($two):
                return 0;
            case empty($one):
                return -1;
            case empty($two):
            default:
                return 1;
        }
    }
}
