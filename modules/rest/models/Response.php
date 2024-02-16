<?php

namespace application\modules\rest\models;

use application\modules\core;

/**
 * @property array  $data     Response data array
 * @property string $language Response language
 */
class Response extends core\models\Response
{
    /**
     * Response language to be used
     *
     * @var string
     */
    public $language = Defines\Language::ENGLISH;
}
