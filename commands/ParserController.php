<?php

namespace application\commands;

use yii;
use application\models;
use application\models\Defines;
use application\models\Parser;
use application\modules\rest\models\Entity as RestEntity;
use application\modules\rest\models\Instance as RestInstance;

class ParserController extends yii\console\Controller
{
    public function default(): models\Dto\CurrencyDto
    {
        return new models\Dto\CurrencyDTO(
            999,
            'RUB',
            1,
            'Российский рубль',
            1,
            1
        );
    }

    public function actionXmlParse(array $args = array())
    {
        $date = date('d/m/Y');
        $url = RestInstance::config()->get('PARSER_XML_URL') . '?date_req=' . $date;
        $data = file_get_contents($url);

        if ($data === false) {
            $this->stderr("Failed to fetch data.\n", \yii\helpers\Console::FG_RED);

            return self::EXIT_CODE_ERROR;
        }
        $parser = parser\ParserFactory::create(Defines\Parser\Type::XML);
        /** @var models\Dto\CurrencyDto[] $currencyDTOs */
        $currencyDTOs = array_merge([$this->default()], $parser->parse());
        foreach ($currencyDTOs as $currencyDTO) {
            $currency = RestEntity\Currency\Repository::findByCode($currencyDTO->code);

            if (!($currency instanceof RestEntity\Currency)) {
                $currency = RestEntity\Currency\Factory::createFromDto($currencyDTO);
                $currency->save();
            }

            $formattedDate = date('Y-m-d', strtotime(str_replace('/', '-', $date)));
            $todayCurrency = RestEntity\Currency\State\Repository::findTodayByCurrencyId($currency->id, $formattedDate);

            if (!($todayCurrency instanceof RestEntity\Currency\State)) {
                $todayCurrency = RestEntity\Currency\State\Factory::createFromDto($currency, $currencyDTO, $formattedDate);
            }

            $todayCurrency->value = $currencyDTO->value;
            $todayCurrency->vUnitRate = $currencyDTO->vUnitRate;

            $todayCurrency->save();
        }
    }
}
