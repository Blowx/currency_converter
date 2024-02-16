<?php
namespace application\models;

class Instance
{
    /**
     * Object instances holder
     *
     * @var array
     */
    static protected $instances = array();

    /**
     * Returns whether class instance exists
     *
     * @param string $className class name to return whether for
     *
     * @return mixed
     */
    public static function has($className)
    {
        return isset(self::$instances[$className]);
    }

    /**
     * Returns instance by class name creating it in case of absence
     *
     * @param string $className class name to return instance for
     *
     * @return mixed
     */
    public static function get($className)
    {
        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new $className();
        }

        return self::$instances[$className];
    }

    /**
     * Sets instance by class name
     *
     * @param string $className Class name to set instance for
     * @param null   $value     value to be set
     */
    public static function set($className, $value = null)
    {
        self::$instances[$className] = $value;
    }
    /**
     * Deletes class instance
     *
     * @param string $className class name to delete
     *
     * @return mixed
     */
    public static function del($className)
    {
        unset(self::$instances[$className]);
    }

    /**
     * Returns current environment value
     *
     * @return string
     */
    public static function environment()
    {
        $value = 'environment';
        if (empty(self::$instances[$value])) {
            $envName = 'production';
            $envFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'env';
            if (file_exists($envFile)) {
                $envName = trim(file_get_contents($envFile));
            }
            self::$instances[$value] = $envName;
        }

        return self::$instances[$value];
    }
}
