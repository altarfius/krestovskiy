<?php

use yii\db\Migration;

/**
 * Class m190422_044444_insert_data_to_status_table
 */
class m190422_044444_insert_data_to_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%status}}', [
            'name', 'stage', 'next_stage', 'style'
        ], [
            //Кандидат
            ['Отказ ресторана', 1, 1, 'secondary'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
