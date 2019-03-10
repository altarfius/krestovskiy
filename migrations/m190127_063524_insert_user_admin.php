<?php

use yii\db\Migration;

/**
 * Class m190127_063524_insert_user_admin
 */
class m190127_063524_insert_user_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'login' => 'admin',
            'surname' => 'Натовский',
            'name' => 'Дмитрий',
            'hash' => '$2y$13$CY6J2KNanmsw2l0qE6V8YeyXmHErlS.wZw1RmeFbPtr4lUrMwen7a',
            'create_time' => DateTime::createFromFormat('U', '1548648501')->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', [
           'login' => 'admin'
        ]);
    }
}
