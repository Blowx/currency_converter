<?php

use yii\db\Migration;

class m240213_155827_crnc_0000_db_fill_configuration extends Migration
{
    public function safeUp()
    {
        $this->insert('configuration', [
            'name' => 'PARSER_XML_URL',
            'value' => 'http://www.cbr.ru/scripts/XML_daily.asp',
            'type' => 'string',
        ]);
        $this->insert('configuration', [
            'name' => 'DEFAULT_CURRENCY_CODE',
            'value' => 'RUB',
            'type' => 'string',
        ]);
    }

    public function safeDown()
    {
        $this->delete('configuration', ['name' => 'DEFAULT_CURRENCY_CODE']);
        $this->delete('configuration', ['name' => 'PARSER_XML_URL']);
    }
}
