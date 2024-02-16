<?php

namespace application\modules\rest\models\Entity;


use application\modules\rest\models;

/**
 * Class QueryConfig
 *
 * @property integer $offset
 * @property string  $sort
 * @property integer $limit
 * @property array   $filter
 * @property string  $sortOrder
 * @property string  $searchEmbedded
 * @property string  $search
 * @property array   $except
 * @property array   $searchArray
 * @package application\modules\rest\models\Entity
 */
class QueryConfig
{
    /**
     * Query offset
     *
     * @var int
     */
    public $offset = 0;

    /**
     * Query sort
     *
     * @var string
     */
    public $sort = '';

    /**
     * Query limit
     *
     * @var integer
     */
    public $limit;

    /**
     * Query filter
     *
     * @var array
     */
    public $filter = [];

    /**
     * Query sort order
     *
     * @var string
     */
    public $sortOrder = '';

    /**
     * Query search string
     *
     * @var string
     */
    public $search;

    /**
     * Query except
     *
     * @var string
     */
    public $except;

    /**
     * Assign request data to config
     *
     * @param models\Request\Search $request Request to assign data from
     */
    public function assignRequestData(models\Request\Search $request)
    {
        $this->limit = $request->limit();
        $this->offset = $request->offset();
        $this->search = $request->search();
        $this->sort = $request->sort($this->sort);
        $this->sortOrder = $request->sortOrder($this->sortOrder);
        $this->except = $request->notIds();
        $this->filter = array_merge($this->filter, $request->filter());
    }

    /**
     * Check if param added to config
     *
     * @param string $param
     *
     * @return bool
     */
    public function hasParam(string $param): bool
    {
        return array_key_exists($param, $this->filter);
    }
}
