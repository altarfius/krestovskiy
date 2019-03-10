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
        $this->batchInsert('{{%status}}', [
            'name', 'stage', 'next_stage', 'style'
        ], [
            //Кандидат
            ['Приглашён на собеседование', 1, 2, 'success'],
            ['Перезвонить', 1, 1, 'warning'],
            ['Перезаписать', 1, 1, 'warning'],
            ['Отказ кандидата', 1, 1, 'danger'],
            ['Отказ отдела персонала', 1, 1, 'danger'],
            ['Не дозвон', 1, 1, 'danger'],
            //Этап личного собеседования
            ['Приглашён на стажировку', 2, 3, 'success'],
            ['Не пришёл на собеседование', 2, 2, 'warning'],
            ['Перезаписать', 2, 2, 'warning'],
            ['Отказ кандидата', 2, 1, 'danger'],
            ['Отказ ресторана', 2, 1, 'danger'],
            ['Отказ отдела персонала', 2, 1, 'danger'],
            //Стажёр
            ['Стажируется с', 3, 4, 'success'],
            ['Перезаписать', 3, 3, 'warning'],
            ['Не вышел на стажировку', 3, 1, 'danger'],
            ['Отказ ресторана', 3, 1, 'danger'],
            ['Отказ стажёра', 3, 1, 'danger'],
            ['Отказ СБ', 3, 1, 'danger'],
            //Окончание стажировки
            ['Работает с', 4, 4, 'success'],
            ['Резерв', 4, 4, 'warning'],
            ['Отказ сотрудника', 4, 1, 'danger'],
            ['Отказ ресторана', 4, 1, 'danger'],
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
