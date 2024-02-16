<?php


namespace application\models;

class Json
{
    /**
     * Settings data array
     *
     * @var array
     */
    protected $data = null;

    public function __construct($json = '')
    {
        $this->setData($json);
    }

    /**
     * Sets settings data from json
     *
     * @param string $json Setting data json encoded
     *
     * @return $this
     */
    public function setData($json = '')
    {
        // decode settings
        $this->data = json_decode($json ?? '', true);
        if (empty($this->data)) {
            $this->data = array();
        }

        return $this;
    }

    /**
     * Returns Settings data either json encoded or array
     *
     * @param bool $encode Flag indicating weather if json should be returned or as array
     *
     * @return array|string
     */
    public function getData($encode = true)
    {
        if ($encode) {
            return json_encode($this->data, true);
        }

        return $this->data;
    }

    /**
     * Returns setting(s) value if any specified or NULL otherwise
     * in case of many settings are requested => array of values is returned
     *
     * @param array|string $name    Settings name to return value for
     * @param mixed        $default Default value if NOT found
     *
     * @return mixed|null
     */
    public function get($name, $default = null)
    {
        // Check for empty name
        if (empty($name)) {
            return null;
        }
        // If list of settings is requested => return array
        if (is_array($name)) {
            $settings = array();
            foreach ($name as $setting) {
                $settings[$setting] = Tools::getValue($this->data, $setting, null);
            }

            return $settings;
        }

        // Return one setting value
        return Tools::getValue($this->data, $name, $default);
    }

    /**
     * Returns setting(s) value recursively if any specified or NULL otherwise
     *
     * @usage getRecursive($key1, ..., $keyN)
     * @return mixed|null
     */
    public function getRecursive()
    {
        $result = null;

        if (func_num_args() >= 1) {
            $data = $this->data;
            $args = func_get_args();

            do {
                $key = array_shift($args);
                switch (true) {
                    // No keys anymore => return data
                    case (null === $key):
                        $result = $data;
                        break 2;
                    // Key not found => return default
                    case (!isset($data[$key])):
                        break 2;
                    // Continue
                    default:
                        $data = $data[$key];
                }
            } while (null !== $key);
        }

        return $result;
    }

    /**
     * Sets value recursively
     *
     * @usage setRecursive($value, $key1, ..., $keyN)
     * @return mixed|null
     */
    public function setRecursive()
    {
        if (func_num_args() >= 2) {
            $data = &$this->data;
            $args = func_get_args();
            $value = array_shift($args);
            do {
                $key = array_shift($args);
                switch (true) {
                    // No keys anymore => return data
                    case (null === $key):
                        $data = $value;
                        break 2;

                    // Continue
                    default:
                        if (!is_array($data)) {
                            $data = array($data);
                        }
                        if (!isset($data[$key])) {
                            $data[$key] = array();
                        }
                        $data = &$data[$key];
                }
            } while (null !== $key);
        }

        return $this;
    }

    /**
     * Sets setting value if any specified or NULL otherwise
     *
     * @param string $name  Settings name to set value for
     * @param mixed  $value Settings value to be set
     *
     * @return $this
     */
    public function set($name, $value)
    {
        if (null === $value) {
            unset($this->data[$name]);
        } else {
            $this->data[$name] = $value;
        }

        return $this;
    }

    /**
     * Adds specified settings into list oeverwriting already existed if any
     *
     * @param array $values List of settings to be replaced (NAME => VALUE)
     *
     * @return $this
     */
    public function add(array $values)
    {
        foreach ($values as $name => $value) {
            $this->set($name, $value);
        }

        return $this;
    }

    /**
     * Searchs for settings with specified name and value (if NOT NULL)
     * and returns weather it's found
     *
     * @param string $name  setting name to be verified
     * @param mixed  $value Setting value to be compared
     *
     * @return boolean
     */
    public function exists($name, $value = null)
    {
        $prev = $this->get($name);
        if (null === $value) {
            return (null !== $prev);
        }

        return ($prev == $value);
    }

    /**
     * Returns weather if all specified entity values are found
     *
     * @param array $values Values (NAME => VALUE) to be find
     *
     * @return  bool
     */
    public function findAll($values)
    {
        foreach ($values as $name => $value) {
            if (!$this->exists($name, $value)) {
                return false;
            }
        }

        return true;
    }
}
