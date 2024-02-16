<?php

namespace application\modules\rest\models;

class WebResponse extends \yii\web\Response
{
    protected function sendContent()
    {
        if (is_null($this->stream) && (is_null($this->content) || $this->content == 'null')) {
            return;
        } else {
            return parent::sendContent();
        }
    }
}
