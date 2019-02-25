<?php

use yii\db\Migration;

/**
 * Class m190128_043913_insert_data_to_category_type
 */
class m190128_043913_insert_data_to_category_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('category_type', [
            'name'
        ], [
            ['Кухня'],
            ['Понтон'],
            ['Сервис'],
            ['Офис'],
            ['Отдел закупок'],
            ['Подсобный рабочий'],
            ['Технический отдел']
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
