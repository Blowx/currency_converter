<?php

namespace application\modules\rest\controllers;

use yii;
use application\modules\rest\models;
use application\modules\rest\models\Action;
use application\modules\rest\models\Defines;

/**
 * Class DefaultAction
 *
 * @package application\modules\rest\controllers*
 */
abstract class DefaultAction extends yii\base\Action
{
    /**
     * @var models\Handler
     */
    private $handler = null;

    /**
     * Returns action handler instance
     *
     * @return models\Handler
     */
    public function handler()
    {
        return new models\Handler();
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->handler = $this->handler();
    }

    /**
     * Performs action processing using specified handler
     *
     * @return int|mixed|null
     * @throws Action\Error
     * @throws \Exception
     */
    public function process()
    {
        return $this->handler->run();
    }

    /**
     * @inheritdocs
     * @throws Action\Error
     */
    public function run()
    {
        try {
            $request = Yii::$app->request;
            # Set language
            Yii::$app->language = Defines\Language::ENGLISH;
            # Assign request data
            models\Request\Helper::assign($this->handler->request, $request);
            # Process and return result
            Yii::$app->response->headers->set("Cache-Control", "no-cache, no-store, must-revalidate");
            Yii::$app->response->data = $this->process();
        } catch (Action\Error $error) {
            # Expected error
            throw $error;
        } catch (\Exception $exception) {
            # Unexpected error => Internal error must be raised
            throw new Action\Error\Internal(Defines\Api\Error::INTERNAL);
        }
    }
}
