<?php

use yii\db\Migration;

/**
 * Class m190310_174136_insert_data_to_division_table
 */
class m190310_174136_insert_data_to_division_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%division}}', [
            'name', 'division_type_id',
        ], [
            ['Карл и Фридрих', 1],
            ['Русская рыбалка КО', 1],
            ['Русская рыбалка Комарово', 1],
            ['Альпенхаус', 1],
            ['Бухгалтерия', 2],
            ['Финансовый отдел', 2],
            ['Отдел закупок', 2],
            ['Технический отдел', 2],
            ['Отдел персонала', 2],
            ['Администрация', 2],
            ['IT-отдел', 2],
            ['Пивовары', 2],
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
