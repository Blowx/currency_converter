<?php

namespace application\modules\core\models\Request;

use application\modules\core\models\Request;

class Helper
{
    /**
     * Returns whether if at least ONE parameter from provided exists
     *
     * @param Request $request Request to be used
     * @param array   $params  Params to be found
     *
     * @return
     */
    public static function findOne(Request $request, array $params)
    {
        foreach ($params as $param) {
            // If array is provided
            if (is_array($param)) {
                // and all exist => ok
                if (true === Helper::findAll($request, $param)) {
                    return true;
                }
            } else {
                // Single parameter found
                if ($request->hasParam($param)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Returns whether if ALL specified parameters are found
     *
     * @param Request $request Request to be used
     * @param array   $params  Params to be found
     *
     * @return
     */
    public static function findAll(Request $request, array $params)
    {
        foreach ($params as $param) {
            // If array is specified as parameter - it's an option
            if (is_array($param)) {
                // At least ONE from list must be found
                if (!Helper::findOne($request, $param)) {
                    return $param;
                }
            } else {
                // Single parameter must exist
                if (!$request->hasParam($param)) {
                    return $param;
                }
            }
        }

        return true;
    }

    /**
     * Implode array values recursively using specified glue type (and / or)
     *
     * @param mixed     $params Parameters array to be implode
     * @param bool|true $every  Flag indicating whether if every or any glue type
     *
     * @return string
     */
    public static function implode($params, bool $every = true): string
    {
        if (!is_array($params)) {
            return $params;
        }

        $result = '';
        $separator = ' or ';
        if ($every) {
            $separator = ' and ';
        }
        $delimiter = '';
        foreach ($params as $param) {
            if (is_array($param)) {
                $value = '(' . Helper::implode($param, !$every) . ')';
            } else {
                $value = $param;
            }
            $result .= $delimiter . $value;
            $delimiter = $separator;
        }

        return $result;
    }
}
