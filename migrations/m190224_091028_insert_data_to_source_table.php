<?php

use yii\db\Migration;

/**
 * Class m190224_091028_insert_data_to_source_table
 */
class m190224_091028_insert_data_to_source_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%source}}', [
            'name'
        ], [
            ['Hh'],
            ['Superjob'],
            ['Worki'],
            ['Avito'],
            ['Restojob'],
            ['От знакомых'],
            ['Vk.com'],
            ['Instagram'],
            ['Наш сайт'],
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
