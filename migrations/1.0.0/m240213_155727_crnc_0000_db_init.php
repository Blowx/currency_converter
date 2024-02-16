<?php

use yii\db\Migration;

class m240213_155727_crnc_0000_db_init extends Migration
{
    public function safeUp()
    {
        $this->createTable(
            'configuration',
            [
                'id' => \yii\db\mysql\Schema::TYPE_PK,
                'name' => $this->string(100),
                'value' => $this->text(),
                'type' => 'enum("string", "int", "float", "array")'
            ],
        );
        $this->createTable(
            'currency',
            [
                'id' => \yii\db\mysql\Schema::TYPE_PK,
                'numCode' => $this->string(),
                'name' => $this->string(),
                'source' => $this->string(),
                'createdAt' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'updatedAt' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'status' => $this->tinyInteger()->defaultValue(0),
                'code' => $this->string(),
            ],
            'DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci'
        );

        $this->createTable(
            'currency_state',
            [
                'id' => \yii\db\mysql\Schema::TYPE_PK,
                'currencyId' => $this->integer(),
                'createdAt' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'updatedAt' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'date' => $this->date(),
                'nominal' => $this->integer(),
                'value' => $this->float(),
                'vUnitRate' => $this->float(),
            ]
        );

        $this->addForeignKey(
            'FK_currency_state_currency_id',
            'currency_state',
            'currencyId',
            'currency',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('FK_currency_state_currency_id', 'currency_state');
        $this->dropTable('currency_state');
        $this->dropTable('currency');
        $this->dropTable('configuration');
    }
}
