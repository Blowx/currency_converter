<?php
namespace application\models\Defines\Config;

class Type
{
    /**
     * String value
     *
     * @var string
     */
    const STRING = 'string';

    /**
     * Integer value
     *
     * @var integer
     */
    const INTEGER = 'int';

    /**
     * Float value
     *
     * @var string
     */
    const FLOAT = 'float';

    /**
     * Array json encoded (before save)
     *
     * @var string
     */
    const JSON_ARRAY = 'array';

    /**
     * Returns weather specified type exists/supported
     *
     * @param string $type Type to verify existance of
     *
     * @return bool
     */
    public static function exists($type)
    {
        switch ($type) {
            case self::STRING:
            case self::INTEGER:
            case self::FLOAT:
            case self::JSON_ARRAY:
                return true;
            default:
                return false;
        }
    }
}
