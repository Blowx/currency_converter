<?php

namespace application\models\Parser;

use application\models;
use application\models\Defines;

class ParserFactory
{
    public static function create(string $type): models\BaseXmlParser
    {
        return match ($type) {
            Defines\Parser\Type::XML => new CbrXmlParser(),
        };
    }
}
