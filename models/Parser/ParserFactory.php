<?php

namespace application\models\Parser;

use application\models;
use application\models\Defines;

class ParserFactory
{
    /**
     * Returns parser by type
     *
     * @param string $type
     *
     * @return models\BaseXmlParser
     */
    public static function create(string $type): models\BaseXmlParser
    {
        return match ($type) {
            Defines\Parser\Type::XML => new CbrXmlParser(),
        };
    }
}
