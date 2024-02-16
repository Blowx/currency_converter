<?php

namespace application\modules\yii\db\Defines\Sql;

class State
{
    /**
     * SQL State prefix used in error messages
     * SQLSTATE[?????]
     *
     * @var string
     */
    const PREFIX = 'SQLSTATE';
    /**
     * SQLSTATE[HY000]: General error:
     * 1205 Lock wait timeout exceeded;
     * try restarting transaction
     *
     * @var string
     */
    const GENERAL = 'HY000';
    /**
     * SQLSTATE[40001]: Serialization failure:
     * 1213 WSREP detected deadlock/conflict and aborted the transaction.
     * Try restarting the transaction
     *
     * @var string
     */
    const DEAD_LOCK = '40001';


    /**
     * PDOStatement::execute(): MySQL server has gone away
     */
    const GONE_AWAY = 'MySQL server has gone away';

    /**
     * Returns SQL Error text for specified state
     *
     * @param string $state State to return error test for
     *
     * @return string
     */
    public static function errorText($state)
    {
        if ($state == State::GONE_AWAY) {
            return $state;
        }

        return sprintf("%s[%s]", State::PREFIX, $state);
    }

    /**
     * Returns whether specified state found in error text
     *
     * @param string $state State to find
     * @param string $error Error text
     *
     * @return boolean
     */
    public static function find($state, $error)
    {
        $text = State::errorText($state);
        $flag = (strpos($error, $text) !== false);

        return $flag;
    }
}
