<?php

use yii\db\Migration;

/**
 * Class m190329_041524_insert_data_to_user_table
 */
class m190329_041524_insert_data_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     *
     * Добавление польхователей: Сенотрусова Валерия
     */
    public function safeUp()
    {
        $this->batchInsert('{{%user}}', [
            'login', 'surname', 'name', 'hash', 'create_time',
        ], [[
            'vsenotrusova', 'Сенотрусова', 'Валерия', '$2y$13$zfoqIJ0cumJo7HjeM3k4herqM2s8IyUMqZ253tk3xrHHBGEWmS.Yu', date('Y-m-d H:i:s'),
        ]]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', [
            'login' => 'vsenotrusova',
        ]);
    }
}
