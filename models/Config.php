<?php

namespace application\models;

use application\modules\core;
use application\models\Defines;
use application\models\entities;

/**
 * Class Config
 *
 * @package application\models
 * @property array $data
 */
class Config
{
    /**
     * configuration values
     *
     * @var entities\Configuration[]
     */
    public $data = null;

    public function __construct()
    {
        $this->load();
    }

    /**
     * @param entities\Configuration $item
     *
     * @return array|float|int|mixed|null|string
     */
    public function getCastedValue(entities\Configuration $item)
    {
        $value = $item->value;
        // Special case for null
        if (is_null($item->value)) {
            $value = null;
        } else {
            switch ($item->type) {
                case Defines\Config\Type::INTEGER:
                    $value = (int)$item->value;
                    break;

                case Defines\Config\Type::FLOAT:
                    $value = (float)$item->value;
                    break;

                case Defines\Config\Type::JSON_ARRAY:
                    $value = json_decode($item->value, true);
                    if (empty($value)) {
                        $value = array();
                    }
                    break;
            }
        }

        return $value;
    }

    /**
     * Returns string representation of provided value
     *
     * @param mixed $value Value to be represented as string
     *
     * @return string
     */
    public function getStringValue($value)
    {
        if (!is_null($value)) {
            if (is_array($value)) {
                $value = json_encode($value);
            } else {
                $value = (string)$value;
            }
        }

        return $value;
    }

    /**
     * Loads all configuration values from database and returns values array
     *
     * @return array
     */
    public function load()
    {
        // Load whole configuration once
        /** @var entities\Configuration[] $data */
        $data = entities\Configuration::find()->all();
        foreach ($data as $item) {
            $this->data[$item->name] = $this->getCastedValue($item);
        }

        return $this->data;
    }

    /**
     * Loads single configuration value from database and returns it
     *
     * @param string $name Value name to load
     *
     * @return mixed
     */
    public function loadSingle($name)
    {
        $item = entities\Configuration::find()->andWhere(array('name' => $name))->one();
        if ($item instanceof entities\Configuration) {
            $this->data[$name] = $this->getCastedValue($item);
        } else {
            $this->data[$name] = null;
        }

        return $this->data[$name];
    }

    /**
     * Returns configuration value for specified Key verifying its type
     *
     * @param string  $name    Key Name of configuration value to be returned
     * @param mixed   $default Default value to be returned if NOT found
     * @param boolean $reload  Flag indicating weather if value must be reloaded from database
     *
     * @return  mixed   Configuration value
     */
    public function get($name, $default = null, $reload = false)
    {
        // Reload value from database if required
        if ($reload) {
            $this->loadSingle($name);
        }
        // By default value
        $value = $default;
        // Check existence
        if (isset($this->data[$name])) {
            $value = $this->data[$name];
        }

        return $value;
    }

    /**
     * Sets configuration value (updating existed or creating new)
     * and store it in database if requires
     *
     * @param string  $name  Configuration key name
     * @param mixed   $value Value to be set
     * @param string  $type  Type of configuration value (Configuration::TYPE_*))
     * @param boolean $store Flag indicating whether if value should be stored permanently
     *
     * @return  $this
     */
    public function set($name, $value, $type = Defines\Config\Type::STRING, $store = false)
    {
        $this->data[$name] = $value;
        if ($store) {
            $item = entities\Configuration::find()->andWhere(array('name' => $name))->one();
            // Create new if not found
            if (!($item instanceof entities\Configuration)) {
                $item = new entities\Configuration();
            }
            // Save new or updated existed configuration value
            $item->name = $name;
            $item->type = $type;
            $item->value = $this->getStringValue($value);
            $item->save();
        }
        // Reload value
        //$this->loadSingle($name);

        return $this;
    }


    /**
     * Returns landing page depending on specified user role if any
     *
     * @param string $role User role to return landing page for
     *
     * @return string
     */
    public function getLandingPage($role = null)
    {
        // Very default landing page
        $url = '/converter';

        return $url;
    }

    /**
     * Returns parameter value by specified path or
     * especially specified config value
     *
     * @param array $path    array of key names
     * @param null  $default default value
     *
     * @return mixed|null
     */
    public function param(array $path, $default = null)
    {
        $data = \Yii::$app->params;
        foreach ($path as $name) {
            $data = core\models\ArrayHelper::getValue($data, $name, $default);
        }
        $name = implode('.', $path);

        return $this->get($name, $data);
    }
}
