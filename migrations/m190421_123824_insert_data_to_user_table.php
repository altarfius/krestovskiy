<?php

use yii\db\Migration;

/**
 * Class m190421_123824_insert_data_to_user_table
 */
class m190421_123824_insert_data_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     *
     * Добавление пользователей: Симонов Александр, Коробкин Владислав.
     */
    public function safeUp()
    {
        $this->batchInsert('{{%user}}', [
            'login', 'surname', 'name', 'hash', 'create_time',
        ], [[
            'asimonov', 'Симонов', 'Александр', '$2y$13$uv7GwDheM9EINgMxWEOOI.56U8g3dAGXGbyCKfwwS5atHUZVfX8aq', date('Y-m-d H:i:s'),
        ], [
            'vkorobkin', 'Коробкин', 'Владислав', '$2y$13$P1Dk.1gYiXFghjwO8R0cWeaj7qi0sE8epr/j8QQNz2PtQFsWfdJ/y', date('Y-m-d H:i:s'),
        ]]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', [
            'login' => 'asimonov',
        ]);
        $this->delete('{{%user}}', [
            'login' => 'vkorobkin',
        ]);
    }
}
