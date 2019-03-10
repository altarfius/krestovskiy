<?php

use yii\db\Migration;

/**
 * Class m190310_164549_insert_users
 */
class m190310_164549_insert_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%user}}', [
            'login', 'surname', 'name', 'hash', 'create_time',
        ], [[
            'aushakova', 'Ушакова', 'Анастасия', '$2y$13$.yVE5bOKf4te3I8hiRFmzeUKWMla4Wf8TXwQ8b.x6b9XoDF300G9C', date('Y-m-d H:i:s'),
        ],[
            'atuch', 'Туч', 'Александра', '$2y$13$qrE.fSNq1qDI42jdyPFe5.05BqvdB7nxpe6fF0J3jJzksZ5/b5Mve', date('Y-m-d H:i:s'),
        ],[
            'amurashova', 'Мурашова', 'Алина', '$2y$13$IpCidapermRSb/.eCtLXI.n5cXe8LtPY6tmSiDoJrGhGGOzXJ/u3e', date('Y-m-d H:i:s'),
        ]]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', [
            'login' => 'aushakova',
        ]);
        $this->delete('{{%user}}', [
            'login' => 'atuch',
        ]);
        $this->delete('{{%user}}', [
            'login' => 'amurashova',
        ]);
    }
}
