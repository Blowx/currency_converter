<?php

namespace application\modules\rest\models\Request;

use application\modules\rest\models;
use application\modules\rest\models\Defines;

/**
 * Class ListRequest
 *
 * @package application\modules\rest\models
 * @property array $allowFilterParams
 */
class Search extends models\Request
{
    /**
     * Allowed filter keys
     *
     * @var array
     */
    public $allowFilterParams = [];

    /**
     * Comma separated parameters in the filter
     *
     * @var array
     */
    public array $filterStrArray = [];

    /**
     * Returns filters for requested value
     *
     * @param string $name
     * @param array  $default
     *
     * @return array
     * @throws \Exception
     */
    public function getFilter(string $name = Defines\Request\Parameter::FILTER, array $default = []): ?array
    {
        $filter = [];
        $data = $this->getArr($name, $default);

        foreach ($data as $key => $value) {
            if (in_array($key, $this->allowFilterParams)) {
                if (in_array($key, $this->filterStrArray)) {
                    $filter[$key] = $this->castStr($value, ',') ?: [$value];
                    continue;
                }
                $filter[$key] = $value;
            }
        }

        return $filter;
    }

    /**
     * Returns offset parameter
     *
     * @return mixed|null
     */
    public function offset()
    {
        return $this->getInt(Defines\Request\Parameter::OFFSET, 0);
    }

    /**
     * Returns sort parameter
     *
     * @return mixed|null
     */
    public function sort(string $default = '')
    {
        return $this->getStr(Defines\Request\Parameter::SORT, $default);
    }

    /**
     * Returns sort parameter
     *
     * @return mixed|null
     */
    public function sortOrder(string $default = '')
    {
        return $this->getStrAllowed(
            Defines\Request\Parameter::SORT_ORDER,
            $default,
            ['ASC', 'DESC']
        );
    }

    /**
     * Returns limit parameter
     *
     * @return int|null
     */
    public function limit()
    {
        $data = $this->getInt(Defines\Request\Parameter::LIMIT);
        if (0 == $data) {
            $data = Defines\Config::DEFAULT_DATA_LIMIT;
        }

        return $data;
    }

    /**
     * Returns search parameter
     *
     * @return mixed|null
     */
    public function search()
    {
        $search = $this->getStr(Defines\Request\Parameter::SEARCH);
        if (strlen($search)) {
            return trim($search);
        }

        return $search;
    }

    /**
     * Returns limit parameter
     *
     * @return array|null
     * @throws \Exception
     */
    public function filter()
    {
        return $this->getFilter();
    }

    /**
     * Returns not ids parameter
     *
     * @return array|null
     */
    public function notIds()
    {
        return $this->getIntExplode(Defines\Request\Parameter::NOT_IDS, [], ';');
    }

    /**
     * Returns not ids parameter
     *
     * @return array|null
     */
    public function notCodes()
    {
        return $this->getStrExplode(Defines\Request\Parameter::NOT_CODES, [], ';');
    }

    /**
     * Returns search list
     *
     * @return array
     */
    public function searchArray(): array
    {
        $separatorOR = Defines\Request\Search::SEPARATOR_OR;
        $search = $this->search();

        if (strlen($search) && stripos($search, $separatorOR) !== false) {
            return array_map('trim', explode($separatorOR, $search));
        }

        return [];
    }
}
