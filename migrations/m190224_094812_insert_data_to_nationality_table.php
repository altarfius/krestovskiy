<?php

use yii\db\Migration;

/**
 * Class m190224_094812_insert_data_to_nationality_table
 */
class m190224_094812_insert_data_to_nationality_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('nationality', [
            'name'
        ], [
            ['РФ'],
            ['Узбекистан'],
            ['Украина'],
            ['Молдова'],
            ['Беларусь'],
            ['Киргизия'],
            ['Таджикистан'],
            ['Азербайджан'],
            ['Казахстан'],
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
