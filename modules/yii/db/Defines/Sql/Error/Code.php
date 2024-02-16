<?php

namespace application\modules\yii\db\Defines\Sql\Error;

use application\modules\yii\db\Defines;

class Code
{
    /**
     * SQLSTATE[HY000]: General error:
     * 1205 Lock wait timeout exceeded;
     * try restarting transaction
     *
     * @var integer
     */
    const LOCK_WAIT = 1205;
    /**
     * SQLSTATE[40001]: Serialization failure:
     * 1213 WSREP detected deadlock/conflict and aborted the transaction.
     * Try restarting the transaction
     *
     * @var integer
     */
    const DEAD_LOCK = 1213;
    /**
     * SQLSTATE[HY000]: General error:
     * 9001 Max connect timeout reached while reaching hostgroup 10 after 11200ms
     *
     * @var integer
     */
    const CONNECT_TIMEOUT = 9001;
    /**
     * SQLSTATE[HY000] [2002] Cannot assign requested address
     *
     * @var integer
     */
    const CONNECT_ADDRESS = 2002;


    /**
     * PDOStatement::execute(): MySQL server has gone away
     *
     */
    const GONE_AWAY = 'MySQL server has gone away';

    /**
     * Returns SQL State corresponding specified error code
     *
     * @param integer $code
     *
     * @return string
     */
    public static function state($code)
    {
        switch ($code) {
            case Code::DEAD_LOCK:
                return Defines\Sql\State::DEAD_LOCK;
            case Code::LOCK_WAIT:
            case Code::CONNECT_TIMEOUT:
            case Code::CONNECT_ADDRESS:
                return Defines\Sql\State::GENERAL;
            case Code::GONE_AWAY:
                return Defines\Sql\State::GONE_AWAY;
            default:
                return null;
        }
    }
}
