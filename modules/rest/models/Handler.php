<?php

namespace application\modules\rest\models;


use Exception;
use yii;
use application\modules\rest\models\Action;
use application\modules\rest\models\Defines;
use application\modules\core;

/**
 * Class Handler (default)
 *
 * @property array   $info
 * @property Request $request
 * @property int     $statusCode
 */
class Handler extends core\models\Handler
{
    /**
     * Flag indicating where if authorization is done
     *
     * @var bool
     */
    public static bool $authorized = false;
    /**
     * Flag indicating whether if permissions are checked
     *
     * @var bool
     */
    public static bool $permitted = false;


    /**
     * Initialization
     */
    public function init()
    {
        $this->request = new Request();
    }

    /**
     * Loads session data
     *
     * @throws Action\Error\Forbidden
     * @throws Action\Error\Unauthorized
     * @throws yii\base\InvalidConfigException
     */
    public function loadSession()
    {
    }

    /**
     * Performs authorization before start of processing
     *
     * @return $this
     * @throws Action\Error\BadRequest
     * @throws Action\Error\Forbidden
     * @throws Action\Error\NotFound
     * @throws yii\base\InvalidConfigException
     */
    public function authorize()
    {

        $this->checkSession();
        Handler::$authorized = true;

        return $this;
    }

    /**
     * Check session
     *
     * @throws Action\Error\BadRequest
     * @throws Action\Error\Forbidden
     */
    public function checkSession(): void
    {

    }

    /**
     * @throws Action\Error\Forbidden
     * @throws Action\Error\NotFound
     */
    public function checkPermission()
    {
        Handler::$permitted = true;
    }

    /**
     * Process specified request and return result
     *
     * @return ?int
     * @throws Action\Error
     */
    public function process()
    {
        return null;
    }

    /**
     * Prepares and returns result depending on request
     *
     * @param mixed $data
     *
     * @return mixed
     */
    public function getResult($data)
    {
        switch (false) {
            case Yii::$app instanceof yii\web\Application:
            case Yii::$app->request instanceof yii\web\Request:
            case Yii::$app->response instanceof yii\web\Response:
            case 'POST' == Yii::$app->request->getMethod():
            case is_int($data) || is_string($data):
                return $data;

            default:
                // All conditions must be met
                $this->statusCode = Defines\Response\Code::CREATED;

                $this->setLocation($data);

                return null;
        }
    }

    /**
     * Set location header
     *
     * @param $url
     * @param $data
     */
    public function setLocation($data)
    {
        $url = Yii::$app->request->url;
        Yii::$app->response->getHeaders()->set('Location', "{$url}/{$data}");
    }

    /**
     * Starts handling performing necessary preparations
     * does processing and returns its result
     *
     * @return int|mixed|null
     * @throws Action\Error
     * @throws Exception
     */
    final public function run()
    {
        try {
            $this->loadSession();
            $this->validateBasic();
            # Authorization
            $this->authorize();
            # Validate permission
            $this->checkPermission();
            # Processing
            $data = $this->process();
            $result = $this->getResult($data);
            // Set up status code
            Yii::$app->response->setStatusCode($this->statusCode);

            return $result;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
}
