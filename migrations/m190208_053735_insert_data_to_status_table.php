<?php

use yii\db\Migration;

/**
 * Class m190208_053735_insert_data_to_status_table
 */
class m190208_053735_insert_data_to_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('status', [
            'name', 'stage', 'next_stage'
        ], [
            ['Отказ ОП', 1, 1],
            ['Отказ кандидата', 1, 1],
            ['Приглашён на собеседование', 1, 2],
            ['Перезвонить', 1, 1],
            ['Не дозвон', 1, 1],
            ['Отказ ОП', 2, 1],
            ['Отказ ресторана', 2, 1],
            ['Отказ кандидата', 2, 1],
            ['Не пришёл на собеседование', 2, 1],
            ['Приглашён на стажировку', 2, 3] //TODO: доделать список статусов
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
