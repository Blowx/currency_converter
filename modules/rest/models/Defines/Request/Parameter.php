<?php

namespace application\modules\rest\models\Defines\Request;


use application\modules\rest\models\Defines;
use application\modules\core;

class Parameter extends core\models\Defines\Request\Parameter
{
    /**
     * Filter data
     *
     * @var string
     */
    const FILTER = 'filter';
    /**
     * Offset for paging
     *
     * @var string
     */
    const OFFSET = 'offset';
    /**
     * Search string
     *
     * @var string
     */
    const SEARCH = 'search';
    /**
     * Name
     *
     * @var string
     */
    const NAME = 'name';
    /**
     * Sort for episodes
     *
     * @var string
     */
    const SORT = 'sort';
    /**
     * Sort order for episodes
     *
     * @var string
     */
    const SORT_ORDER = 'sortOrder';
    /**
     * Limit of episodes
     *
     * @var string
     */
    const LIMIT = 'limit';

    /**
     * Not ids
     *
     * @var string
     */
    const NOT_IDS = 'id!';

    /**
     * Not ids
     *
     * @var string
     */
    const NOT_CODES = 'code!';

    /**
     * id
     *
     * @var string
     */
    const ID = 'id';

    /**
     * status
     *
     * @var string
     */
    const STATUS = 'status';

    /**
     * Num code
     *
     * @var string
     */
    const NUM_CODE = 'numCode';

    /**
     * code
     *
     * @var string
     */
    const CODE = 'code';
    /**
     * CreatedAt
     *
     * @var string
     */
    const CREATED_AT = 'createdAt';
    /**
     * updatedAt
     *
     * @var string
     */
    const UPDATED_AT = 'updatedAt';

    /**
     * Amount
     *
     * @var string
     */
    const AMOUNT = 'amount';

    /**
     * Priority
     *
     * @var string
     */
    const PRIORITY = 'priority';
}
