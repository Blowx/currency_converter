<?php
namespace application\modules\yii\db\Defines;

class Connection
{
    /**
     * Maximal attempts amount to open connection
     *
     * @var integer
     */
    const MAX_OPEN_RETRY = 3;
    /**
     * Default maximal retry for locks
     *
     * @var integer
     */
    const MAX_LOCK_RETRY = 3;
    /**
     * Log prefix
     *
     * @var string
     */
    const LOG_PREFIX_ERR = 'MYSQL ERROR';
}
