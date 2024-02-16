<?php
namespace application\modules\yii\db;

use yii;

/**
 * Class Connection
 *
 * @package application\modules\yii\db
 * @property integer $retryCount
 * @property array   $retryError
 */
class Connection extends yii\db\Connection
{
    /**
     * Maximal retry attempts allowed
     *
     * @var int
     */
    public $retryCount = Defines\Connection::MAX_OPEN_RETRY;
    /**
     * List of sql error codes allowed for retry
     *
     * @var array
     */
    public $retryError = [
        Defines\Sql\Error\Code::CONNECT_ADDRESS,
        Defines\Sql\Error\Code::CONNECT_TIMEOUT,
    ];

    /**
     * @inheritdoc
     */
    public function open()
    {
        for ($i = 1; $i <= $this->retryCount; $i++) {
            try {
                // Open connection
                parent::open();
            } catch (\Exception $error) {
                // Check for error
                Helper::checkError($error, $this->retryError, $i, $this->retryCount);
                continue;
            }
        }
    }
}
