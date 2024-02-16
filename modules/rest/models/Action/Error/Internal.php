<?php
namespace application\modules\rest\models\Action\Error;

use application\modules\rest\models;
use application\modules\rest\models\Defines;

class Internal extends models\Action\Error
{
    /**
     * Create using specified Error Code
     *
     * @param int  $code Internal Error Code
     * @param null $data Additional Error Data
     */
    public function __construct($code = 0, $data = null)
    {
        parent::__construct(Defines\Response\Code::INTERNAL, $code, $data);
    }
}
