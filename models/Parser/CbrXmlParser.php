<?php

namespace application\models\Parser;

use application\models;

final class CbrXmlParser extends models\BaseXmlParser
{
    public function parse(): array
    {
        $result = [];

        foreach ($this->getXmlData()->Valute as $valute) {
            $currencyDto = new models\Dto\CurrencyDto(
                (string)$valute->NumCode,
                (string)$valute->CharCode,
                (int)$valute->Nominal,
                (string)$valute->Name,
                (float)str_replace(',', '.', $valute->Value),
                (float)str_replace(',', '.', $valute->VunitRate)
            );

            $result[] = $currencyDto;
        }

        return $result;
    }

    public function getUrlKey()
    {
        return 'PARSER_XML_URL';
    }
}
