<?php

namespace application\commands;

use yii;
use application\models;
use application\models\Defines;
use application\models\Parser;
use application\modules\rest\models\Defines as RestDefines;
use application\modules\rest\models\Entity as RestEntity;
use application\modules\rest\models\Instance as RestInstance;
use yii\console\ExitCode;

class ParserController extends yii\console\Controller
{
    /**
     * Returns first DTO as russian language
     *
     * @return models\Dto\CurrencyDto
     */
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

    /**
     * Run this action by executing command `php yii parser/xml-parse`
     * Parses information from the link and adds it to database
     *
     * @param array $args
     *
     * @return int
     * @throws \application\modules\rest\models\Action\Error\BadRequest
     */
    public function actionXmlParse(array $args = array())
    {
        $date = date('d/m/Y');
        $url = RestInstance::config()->get('PARSER_XML_URL') . '?date_req=' . $date;
        $data = file_get_contents($url);

        if ($data === false) {
            $this->stderr("Failed to fetch data.\n", \yii\helpers\Console::FG_RED);

            return ExitCode::UNSPECIFIED_ERROR;
        }
        $parser = parser\ParserFactory::create(Defines\Parser\Type::XML);
        /** @var models\Dto\CurrencyDto[] $currencyDTOs */
        $currencyDTOs = array_merge([$this->default()], $parser->parse());
        foreach ($currencyDTOs as $currencyDTO) {
            $currency = RestEntity\Currency\Repository::findByCode($currencyDTO->code);

            if (!( $currency instanceof RestEntity\Currency )) {
                $currency = RestEntity\Currency\Factory::createFromDto($currencyDTO);
                $currency->save();
            }
            $this->updatePriority($currency);

            $formattedDate = date('Y-m-d', strtotime(str_replace('/', '-', $date)));
            $todayCurrency = RestEntity\Currency\State\Repository::findTodayByCurrencyId($currency->id, $formattedDate);

            if (!( $todayCurrency instanceof RestEntity\Currency\State )) {
                $todayCurrency = RestEntity\Currency\State\Factory::createFromDto($currency, $currencyDTO,
                    $formattedDate);
            }

            $todayCurrency->value = $currencyDTO->value;
            $todayCurrency->vUnitRate = $currencyDTO->vUnitRate;

            $todayCurrency->save();
        }

        return ExitCode::OK;
    }

    /**
     * Updates Currency's priority, in case if currency was added before adding field priority
     *
     * @param RestEntity\Currency $currency
     *
     * @return void
     * @throws \application\modules\rest\models\Action\Error\BadRequest
     */
    private function updatePriority(RestEntity\Currency $currency): void
    {
        if (RestDefines\Currency\Code::isTopPrio($currency->code)
            && $currency->priority !== $newPriority = RestDefines\Currency\Priority::getByCode($currency->code)) {
            $currency->priority = $newPriority;
            $currency->save();
        }
    }
}
