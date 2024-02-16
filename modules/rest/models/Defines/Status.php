<?php

namespace application\modules\rest\models\Defines;

class Status
{
    /**
     * Inactive status
     *
     * @var integer
     */
    const INACTIVE = 0;
    /**
     * Active status
     *
     * @var integer
     */
    const ACTIVE = 1;

    /**
     * Get list of statuses
     *
     * @return array
     */
    public static function getList(): array
    {
        return [
            Status::ACTIVE,
            Status::INACTIVE,
        ];
    }

    /**
     * Checks status for existence
     *
     * @param $status
     *
     * @return bool
     */
    public static function exists($status): bool
    {
        return in_array($status, self::getList());
    }
}
