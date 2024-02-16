<?php

namespace application\modules\core\models;

class Response
{
    /**
     * Response data values array
     *
     * @var array|null
     */
    public $data = null;

    /**
     * Returns response data array
     *
     * @return array
     */
    public function prepare()
    {
        return $this->data;
    }

    /**
     * Set headers
     *
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        foreach ($headers as $header => $value) {
            \yii::$app->response->headers->add($header, $value);
        }
    }
}
