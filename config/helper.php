<?php

/**
 * Returns value of specified OS environment variable
 * if variable is absent returns $default
 *
 * @param string $name    Name of variable to return
 * @param string $default Default value if variable is not set
 *
 * @return array|string
 */
function getEnvVal(string $name, string $default = '')
{
    $value = $default;
    if (isset($_ENV[$name])) {
        $value = $_ENV[$name];
    }

    return $value;
}
