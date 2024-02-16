<?php

namespace application\modules\rest\models;

interface EntityInterface
{

    /**
     * Returns list of json attributes
     *
     * @return array
     */
    public function jsonFields();

    /**
     * Returns field value by name
     *
     * @param string $name Field to return value for
     *
     * @return mixed
     */
    public function __get($name);

    /**
     * Sets specified field value
     *
     * @param string $name  Field name to set value for
     * @param mixed  $value Value to be set
     *
     * @return mixed
     */
    public function __set($name, $value);

}
