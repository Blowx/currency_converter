<?php
namespace app\controllers;

use application\modules\rest\models\Instance;
use yii\web\Controller;

class SiteController extends Controller
{

    /**
     * Returns landing page URL for current state
     *
     * @return string
     */
    public static function landingPage()
    {
        return Instance::config()->getLandingPage();
    }

    /**
     * Default site action
     */
    public function actionIndex()
    {
        $page = self::landingPage();
        $this->redirect(\Yii::$app->urlManager->createUrl($page), 301);
    }
}
