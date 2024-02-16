<?php

namespace application\modules\yii\db;

class PDO extends \PDO
{

    /**
     * PDO constructor.
     *
     * @param       $dsn
     * @param       $username
     * @param       $passwd
     * @param array $options
     */
    public function __construct($dsn, $username, $passwd, $options = array())
    {
        parent::__construct($dsn, $username, $passwd, $options);
        $this->setAttribute(PDO::ATTR_STATEMENT_CLASS,
            array('application\modules\yii\db\PDOStatement'));
    }
}
