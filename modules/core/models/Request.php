<?php

namespace application\modules\core\models;

class Request
{
    /**
     * Request URL and Method used to call
     *
     * @var string
     */
    public string $target = '';
    /**
     * Request parameters
     *
     * @var array
     */
    public array $params = [];
    /**
     * Whether convert "null" string values to null
     *
     * @var bool
     */
    public bool $strNull = false;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        $this->target = get_called_class();
    }

    /**
     * Returns list of mandatory parameters
     * Logical rules by level are AND, OR, AND
     * e.g.
     * ['a', 'b'] - means (a AND b) must exist
     * ['a', ['b', 'c']] = means (a AND (b OR c)) ,ust exist
     * ['a', ['b', ['c', 'd']]] - means (a AND (b or (c AND d)))
     *
     * @return array
     */
    public function required()
    {
        return [];
    }

    /**
     * Returns embedded data
     *
     * @return array|null
     */
    public function embedded(): ?array
    {
        return StringHelper::split($this->getStr(Defines\Request\Parameter::EMBEDDED), ',');
    }

    /**
     * Returns scope value
     *
     * @return array
     */
    public function scope(): array
    {
        return StringHelper::split($this->getStr(Defines\Request\Parameter::SCOPE), ',');
    }

    /**
     * Initialize Request parameters
     *
     * @param array $data
     */
    public function setParams(array $data)
    {
        // Initialize configured parameters
        foreach ($data as $name => $value) {
            $this->setParam($name, $value);
        }
    }

    /**
     * Sets request parameter
     *
     * @param string $name  Parameter name to set value for or null for all
     * @param mixed  $value Parameter to be set
     *
     * @return $this
     */
    public function setParam(string $name, $value): Request
    {
        $this->params[$name] = $value;

        return $this;
    }

    /**
     * Returns parameter value by name or default if absent
     *
     * @param string $name    Parameter name to return value for or null for all
     * @param mixed  $default Default value to be returned
     *
     * @return mixed|null
     */
    public function getParam(string $name, $default = null)
    {
        if (!empty($name) && $this->hasParam($name)) {
            $val = $this->params[$name];
            // Convert "null" string value to null
            if ($this->strNull && is_string($val) && 'null' === strtolower($val)) {
                $val = null;
            }

            return $val;
        }

        return $default;
    }

    /**
     * Check if param exist or not
     *
     * @param string $name Parameter name to checking if it exists
     *
     * @return bool
     */
    public function hasParam(string $name): bool
    {
        return array_key_exists($name, $this->params);
    }

    /**
     * Casts specified parameter value to integer before returning
     *
     * @param string $name    Parameter name
     * @param int    $default Default value to return
     * @param ?bool  $checkOnNullValue
     *
     * @return int
     */
    public function getInt(string $name, $default = 0, bool $checkOnNullValue = false)
    {
        $value = $this->getParam($name);
        if (($checkOnNullValue && is_null($value)) || !$this->hasParam($name)) {
            return $default;
        }

        return intval($this->getParam($name, $default));
    }

    /**
     * Returns array of integer values casting them before return
     *
     * @param string $name    Parameter name
     * @param ?array $default Default value to return
     *
     * @return ?array
     */
    public function getIntArray(string $name, ?array $default = []): ?array
    {
        $value = $this->getParam($name, $default);
        if (is_array($value)) {
            return ArrayHelper::castValues($value, 'intval');
        }

        return $default;
    }

    /**
     * Returns array of integer values exploding parameter before return
     *
     * @param string $name      Parameter name
     * @param ?array $default   Default value
     * @param string $delimiter Values delimiter
     *
     * @return ?int[]
     * @throws \Exception
     */
    public function getIntExplode(string $name, ?array $default = [], string $delimiter = ','): ?array
    {
        $value = $this->getParam($name, $default);
        if (!empty($value) && is_scalar($value) && !empty($arr = explode($delimiter, $value))) {
            return ArrayHelper::castValues($arr, 'intval');
        }

        return $default;
    }

    /**
     * Returns array of string values exploding parameter before return
     *
     * @param string $name      Parameter name
     * @param ?array $default   Default value
     * @param string $delimiter Values delimiter
     *
     * @return ?int[]
     * @throws \Exception
     */
    public function getStrExplode(string $name, ?array $default = [], string $delimiter = ','): ?array
    {
        $value = $this->getParam($name, $default);
        if (!empty($value) && is_scalar($value) && !empty($arr = explode($delimiter, $value))) {
            return ArrayHelper::castValues($arr, 'strval');
        }

        return $default;
    }

    /**
     * @param $value
     * @param $delimiter
     *
     * @return array|void
     * @throws \Exception
     */
    protected function castStr($value, $delimiter)
    {
        if (!empty($value) && !empty($arr = explode($delimiter, $value))) {
            return $this->cleanupStrArray(ArrayHelper::castValues($arr));
        }

        return null;
    }

    /**
     * Casts specified parameter value to float before returning
     *
     * @param string $name    Parameter name
     * @param ?float $default Default value to return
     *
     * @return float
     */
    public function getFlt(string $name, ?float $default = 0.0): float
    {
        $value = $this->getParam($name, $default);

        return floatval($value);
    }

    /**
     * Returns array of float values casting them before return
     *
     * @param string $name    Parameter name
     * @param ?array $default Default value to return
     *
     * @return ?array
     */
    public function getFltArray(string $name, ?array $default = []): ?array
    {
        $value = $this->getParam($name, $default);
        if (is_array($value)) {
            return ArrayHelper::castValues($value, 'floatval');
        }

        return $default;
    }

    /**
     * Encodes specified parameter value to before  returning
     *
     * @param string $name        Parameter name
     * @param mixed  $default     Default value to return
     * @param array  $includeTags Tags that do NOT need to be replaced
     *
     * @return string|mixed
     */
    public function getStr(string $name, $default = '', array $includeTags = [])
    {
        $value = $this->getParam($name, $default);
        if (is_string($value)) {
            if (count($includeTags) > 0) {
                return preg_replace_callback(
                    Defines\Request\RegularExpression::TEXT_CLEANUP_TAGS,
                    function ($matches) use ($includeTags) {
                        // check if matching tag should be included
                        foreach ($includeTags as $includeTag) {
                            if (str_starts_with($matches[0], "<$includeTag")
                                || str_ends_with($matches[0], "$includeTag>")) {
                                return $matches[0];
                            }
                        }

                        return '';
                    },
                    $value
                );
            }

            return preg_replace(Defines\Request\RegularExpression::TEXT_CLEANUP_TAGS, '', $value);
        }

        return $default;
    }

    /**
     * Returns HTML string value
     *
     * @param string $name
     * @param string $default
     *
     * @return void
     */
    public function getHtml(string $name, string $default = ''): string
    {
        $value = $this->getParam($name, $default);

        return preg_replace(Defines\Request\RegularExpression::htmlCleanupExpression(), '', $value);
    }

    /**
     * Returns array of float values casting them before return
     *
     * @param string $name        Parameter name
     * @param ?array $default     Default value to return
     * @param int    $cleanUpRule Rule for clean tags
     *
     * @return array
     */
    public function getStrArray(
        string $name,
        $default = [],
        int $cleanUpRule = Defines\Request\CleanUpRules::TEXT
    ) {
        $array = $this->cleanupStrArray($this->getParam($name, $default), $cleanUpRule);
        if (!is_null($array)) {
            return $array;
        }

        return $default;
    }

    /**
     * Cleanup string array
     *
     * @param     $array
     * @param int $cleanUpRule
     *
     * @return array|null
     */
    protected function cleanupStrArray($array, int $cleanUpRule = Defines\Request\CleanUpRules::TEXT): ?array
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                // Cast scalar values only
                $array[$key] = $this->cleanUpTags($value, $cleanUpRule);
            }

            return $array;
        }

        return null;
    }

    /**
     * Clean tags from string
     *
     * @param string|null $value       String to prepare
     * @param int         $cleanUpRule Rule for clean tags
     *
     * @return string|string[]|null
     */
    public function cleanUpTags($value, int $cleanUpRule)
    {
        if (!is_scalar($value)) {
            return '';
        }

        switch ($cleanUpRule) {
            case Defines\Request\CleanUpRules::HTML:
                return preg_replace(Defines\Request\RegularExpression::htmlCleanupExpression(), '', $value);
            default:
                return preg_replace(Defines\Request\RegularExpression::TEXT_CLEANUP_TAGS, '', $value);
        }
    }

    /**
     * Returns array of values casting them before return
     *
     * @param string $name    Parameter name
     * @param ?array $default Default value to return
     *
     * @return array
     */
    public function getArr(string $name, $default = []): ?array
    {
        $array = $this->getParam($name, $default);
        if (is_array($array)) {
            return $array;
        }

        return $default;
    }

    /**
     * Returns timestamp for requested value
     *
     * @param string $name
     * @param ?int   $default
     *
     * @return false|int
     */
    public function getTimeStamp(string $name, ?int $default = 0)
    {
        return $this->getInt($name, $default);
    }

    /**
     * Returns specified parameter value from allowed list
     *
     * @param string   $name    Parameter name
     * @param ?string  $default Default value to return
     * @param string[] $allowed List of allowed values
     * @param boolean  $case    Flag indicating whether if value is case-sensitive
     *
     * @return string
     */
    public function getStrAllowed(string $name, ?string $default = '', array $allowed = [], bool $case = false): ?string
    {
        $value = $this->getStr($name, $default);
        // Check for allowed values if any
        if ($case) {
            $found = in_array($value, $allowed);
        } else {
            $found = (false !== array_search(strtolower($value), array_map('strtolower', $allowed)));
        }
        if (!$found) {
            $value = $default;
        }

        return $value;
    }

    /**
     * Validates received request and returns whether it's valid or not
     *
     * @return bool
     */
    public function validate()
    {
        return $this->validateRequired();
    }

    /**
     * Validate Required parameters
     *
     * @return ?bool
     */
    public function validateRequired()
    {
        return Request\Helper::findAll($this, $this->required());
    }
}
