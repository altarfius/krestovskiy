<?php

use yii\db\Migration;

/**
 * Class m190310_173915_insert_data_to_division_type_table
 */
class m190310_173915_insert_data_to_division_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%division_type}}', [
            'name',
        ], [
            ['Ресторан'],
            ['Офис'],
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
