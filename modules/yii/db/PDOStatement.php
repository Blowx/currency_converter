<?php

namespace application\modules\yii\db;


/**
 * Class PDOStatement
 *
 * @package application\modules\yii\db
 * @property integer $retryCount
 * @property array   $retryError
 */
class PDOStatement extends \PDOStatement
{
    /**
     * Maximal retry attempts allowed
     *
     * @var int
     */
    public $retryCount = Defines\Connection::MAX_LOCK_RETRY;
    /**
     * List of sql error codes allowed for retry
     *
     * @var array
     */
    public $retryError = [
        Defines\Sql\Error\Code::DEAD_LOCK,
        Defines\Sql\Error\Code::LOCK_WAIT,
        Defines\Sql\Error\Code::CONNECT_TIMEOUT,
        Defines\Sql\Error\Code::GONE_AWAY,
    ];

    /**
     * 1205 - 1213, ER_LOCK_DEADLOCK, ERR_LOCK_WAIT_TIMEOUT
     * ERROR (0) EXCEPTION (yii\db\Exception):
     * [2] PDOStatement::execute(): MySQL server has gone away
     *
     * @param null $input_parameters
     *
     * @return bool|int
     * @throws \Exception
     */
    public function execute($input_parameters = null)
    {
        for ($i = 1; $i <= $this->retryCount; $i++) {
            try {
                // Execute statement
                return parent::execute($input_parameters = null);
            } catch (\Exception $error) {
                // Check for error
                Helper::checkError($error, $this->retryError, $i, $this->retryCount);
                continue;
            }
        }

        return 0;
    }
}
