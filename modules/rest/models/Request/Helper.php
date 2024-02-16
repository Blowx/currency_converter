<?php

namespace application\modules\rest\models\Request;

use application\modules\core\models\Request;
use yii;
use application\modules\rest\models;
use application\modules\rest\models\Defines;
use application\modules\rest\models\Instance;
use application\modules\rest\models\Action;

class Helper extends Request\Helper
{

    /**
     * Assign API request data from Web request
     * initializing additional parameters as required
     *
     * @param models\Request  $request    Api request to assign with data
     * @param yii\web\Request $webRequest Web request to be used as source
     *
     * @throws Action\Error\BadRequest
     */
    public static function assign(Request $request, yii\web\Request $webRequest)
    {
        $request->target = Helper::getInfo($webRequest);
        // Set params from Raw Body (catches invalid JSON data error)
        try {
            $data = $webRequest->getBodyParams();
            $request->setParams($data);

            // Set params from Query
            $params = $webRequest->getQueryParams();
            $request->setParams($params);

        } catch (\Exception $exception) {
            throw new Action\Error\BadRequest(Defines\Api\Error::INVALID_REQUEST_DATA);
        }
    }

    /**
     * Extracts request URI and returns
     *
     * @param yii\web\Request $request Request to extract URI for
     *
     * @return string
     */
    public static function getUri(yii\web\Request $request)
    {
        $uri = $request->getUrl();
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        return $uri;
    }

    /**
     * Returns info message for log
     *
     * @param yii\web\Request $request Request to take data from
     *
     * @return string
     */
    public static function getInfo(yii\web\Request $request)
    {
        return models\Request\Helper::getUri($request) . ' ' . $request->getMethod();
    }
}
