<?php

namespace application\models;

use application\modules\rest\models\Instance as RestInstance;

abstract class BaseXmlParser implements ParserInterface
{

    /**
     * @inheritDoc
     */
    abstract function getUrlKey();

    /**
     * Returns information from the link
     *
     * @return \SimpleXMLElement
     */
    protected function getXmlData(): \SimpleXMLElement
    {
        $url = RestInstance::config()->get($this->getUrlKey());
        $content = file_get_contents($url);

        return simplexml_load_string($content);
    }
}
