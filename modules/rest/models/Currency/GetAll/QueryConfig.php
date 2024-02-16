<?php

namespace application\modules\rest\models\Currency\GetAll;

use application\modules\rest\models;
use application\modules\rest\models\Entity;

class QueryConfig extends Entity\QueryConfig
{
    public function assignRequestData(models\Request\Search $request)
    {
        parent::assignRequestData($request);

        $this->except = $request->notCodes();
        $this->sortOrder = $request->sortOrder('ASC');
    }
}
