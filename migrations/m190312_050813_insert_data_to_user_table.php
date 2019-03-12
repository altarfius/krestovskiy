<?php

use yii\db\Migration;

/**
 * Class m190312_050813_insert_data_to_user_table
 */
class m190312_050813_insert_data_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     *
     * Добавление польхователей: Четвериков Анатолий, Долматова Елена
     */
    public function safeUp()
    {
        $this->batchInsert('{{%user}}', [
            'login', 'surname', 'name', 'hash', 'create_time',
        ], [[
            'achetverikov', 'Четвериков', 'Анатолий', '$2y$13$2yVGk2oLg99Sh4savisXkeQZFe5nUC3m3WjH4oJouSW.h3sSP5BHy', date('Y-m-d H:i:s'),
        ],[
            'edolmatova', 'Долматова', 'Елена', '$2y$13$/2SQDIAHXgoTLqrVZAblp.y4MSKB31.Q74zGFXHaxHCwTjDf4m/2m', date('Y-m-d H:i:s'),
        ]]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', [
            'login' => 'achetverikov',
        ]);
        $this->delete('{{%user}}', [
            'login' => 'edolmatova',
        ]);
    }

}
