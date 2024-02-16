<?php

namespace application\modules\core\models;

use yii;

/**
 * @property Request $request
 */
class Handler
{
    /**
     * Stores additional info if any
     *
     * @var array
     */
    public array $info = [];
    /**
     * @var ?Request
     */
    public $request = null;
    /**
     * Response status code value
     *
     * @var int
     */
    public int $statusCode = Defines\Response\Code::OK;
    /**
     * Flag indicating where if authorization is done
     *
     * @var bool
     */
    public static bool $authorized = false;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Initialization
     */
    public function init()
    {
        $this->request = new Request();
    }

    /**
     * Process specified request and return result
     *
     * @return ?null
     */
    public function process()
    {
        return null;
    }

    /**
     * Prepare GET response: truncates nearly all data to prevent performance issues
     *
     * @param array|null $data
     *
     * @return array|null
     */
    public function prepareResult(array $data): array
    {
        switch (true) {
            case ArrayHelper::keyExists('count', $data):
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $count = count($value);
                        $newData = [];
                        $newData[$key] = [reset($data[$key])];
                        $newData['info'] = Yii::t('api', 'LB_LOG_ARRAY_INFO', ['count' => $count]);

                        return array_merge($data, $newData);
                    }
                }
                break;
            case $data === array_values($data):
                $count = count($data);
                $newData = [];
                $newData['items'][] = reset($data);
                $newData['info'] = Yii::t('api', 'LB_LOG_ARRAY_INFO', ['count' => $count]);

                return $newData;
            case ArrayHelper::keyExists('id', $data):
            default:
                return $data;
        }
    }

    /**
     * Performs basic validation
     *
     * @return void
     */
    public function validateBasic()
    {
        $this->request->validate();
    }
}
