<?php

namespace application\modules\rest\models\Currency\Exchange\GetAll;

use application\modules\rest\models;
use application\modules\rest\models\Entity;

class QueryConfig extends Entity\QueryConfig
{
    /**
     * @inheritdoc
     */
    public function assignRequestData(models\Request\Search $request)
    {
        parent::assignRequestData($request);

        $this->except = $request->notCodes();
        $this->sortOrder = $request->sortOrder('ASC');
    }
}
