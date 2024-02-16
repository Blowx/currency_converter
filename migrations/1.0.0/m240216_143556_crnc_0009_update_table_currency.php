<?php

use yii\db\Migration;

use application\modules\rest\models;
use application\modules\rest\models\Defines;

/**
 * Class m240216_143556_crnc_0009_update_table_currency
 */
class m240216_143556_crnc_0009_update_table_currency extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Defines\Entity\Table::CURRENCY, 'priority', $this->integer()->defaultValue
        (Defines\Currency\Priority::LOW_PRIO));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Defines\Entity\Table::CURRENCY, 'priority');
    }
}
