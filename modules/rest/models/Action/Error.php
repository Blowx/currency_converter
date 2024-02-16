<?php

namespace application\modules\rest\models\Action;

use yii;
use application\modules\rest\models\Defines;

class Error extends yii\web\HttpException implements \Throwable
{
    /**
     * Create using specified Error Code and Http Status
     *
     * @param int         $status Http status
     * @param int         $code   Internal Error Code
     * @param null        $data   Additional Error Data
     * @param string|null $text   Custom error text
     */
    public function __construct($status, $code = 0, $data = null, $text = null)
    {
        if (empty($text)) {
            $text = Defines\Api\Error::getText($code);
            $text = "[{$code}] {$text}";
        }
        if (null !== $data) {
            if (is_object($data) && get_class($data) == 'Exception') {
                /** @var \Exception $data */
                $data = "Exception: [{$data->getCode()}] {$data->getMessage()}";
            }

            if (is_array($data)) {
                $text = sprintf($text, ...$data);
            } else {
                $text = sprintf($text, $data);
            }
        }

        parent::__construct($status, $text, $code, null);
    }

    /**
     * Returns array of exception data
     *
     * @return array
     */
    public function getData()
    {
        return [
            'stat' => $this->statusCode,
            'code' => $this->code,
            'text' => $this->message,
            'file' => $this->file,
            'line' => $this->line,
        ];
    }
}
