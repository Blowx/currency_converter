<?php

/**
 * Returns current environment name
 *
 * @return string
 */
function getEnvironment()
{
    $environment = 'production';
    $envFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'env';
    if (file_exists($envFile)) {
        $environment = trim(file_get_contents($envFile));
    }

    return $environment;
}

/**
 * Returns configuration data by name
 *
 * @param string     $name      Configuration name
 * @param bool|false $mustExist Weather it must exist or not
 *
 * @return array|mixed
 *
 * @throws Exception
 */
function getConfigData($name, $mustExist = false)
{
    $data = array();
    // Path to config
    $configPath = dirname(__FILE__)
        . DIRECTORY_SEPARATOR . "{$name}.php";
    if (file_exists($configPath)) {
        // Load config data
        $data = require_once( $configPath );
    } else {
        // Check for existence if necessaryMain config file MUST EXIST
        if ($mustExist) {
            throw new Exception("'$name' config NOT found at '{$configPath}'!");
        }
    }

    return $data;
}

/**
 * Load component configuration data by name
 *
 * @param string $name Name of component to load configuration for
 *
 * @return array
 */
function loadComponent($type, $name)
{
    $environmentDir = 'environments' . DIRECTORY_SEPARATOR . getEnvironment() . DIRECTORY_SEPARATOR;

    $configDataBase = array_merge(getConfigData($name, true), getConfigData("{$environmentDir}{$name}"));
    $configDataSpec = array_merge(getConfigData("{$type}_{$name}"), getConfigData("{$environmentDir}{$type}_{$name}"));

    return array_merge($configDataBase, $configDataSpec);
}

/**
 * Loads all necessary configuration data and returns it
 *
 * @param string $type configuration type: console, server, test
 *
 * @return array|mixed
 *
 * @throws Exception
 */
function loadConfig($type)
{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '../.env');
    $dotenv->load();
    $environmentDir = 'environments' . DIRECTORY_SEPARATOR . getEnvironment() . DIRECTORY_SEPARATOR;
    // Load main config - MUST EXIST, Environment dependent main setting changes - if any
    $configDataMain = array_merge(getConfigData('main', true), getConfigData("{$environmentDir}main"));
    // Application type dependent settings
    $configDataType = array_replace_recursive(getConfigData($type, true), getConfigData("{$environmentDir}{$type}"));
    // Merge config data
    $config = array_replace_recursive($configDataMain, $configDataType);
    // MySql Database configuration
    $config[ 'components' ][ 'db' ] = loadComponent($type, 'db');
    // Parameters configuration
    $configSettings = array_merge(getConfigData('params', true), getConfigData("{$environmentDir}params"));
    $config[ 'params' ] = $configSettings;


    return $config;
}
