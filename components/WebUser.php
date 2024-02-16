<?php


namespace application\components;

use application\models\entities\User;
use yii\web\Cookie;

/**
 * Class WebUser
 *
 * @package application\components
 * @property User $identity
 */
class WebUser extends \yii\web\User
{
    /** @var  User */
    protected $model;

    /**
     * Load user data and its permissions     *
     *
     * @return bool
     */
    protected function beforeLogin($identity, $cookieBased, $duration)
    {
        $this->loadPermissions();

        return parent::beforeLogin($identity, $cookieBased, $duration);
    }

    protected function afterLogin($identity, $cookieBased, $duration)
    {
        \Yii::$app->response->cookies->add(
            new Cookie(
                [
                    'name' => 'language',
                    'value' => strtolower($this->identity->lang),
                ]
            )
        );
        parent::afterLogin($identity, $cookieBased, $duration);
    }

    protected function afterLogout($identity)
    {
        \Yii::$app->user->removeIdentityCookie();
        \Yii::$app->response->cookies->remove('language');
        parent::afterLogout($identity);
    }

    public function getModel()
    {
        return $this->identity;
    }
}
