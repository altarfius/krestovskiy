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
        $this->insert('user', [
            'login' => 'admin',
            'surname' => 'Натовский',
            'name' => 'Дмитрий',
            'hash' => '1ecd5abcec35d73c5919e3c286e8116d49e3374f',
            'create_time' => DateTime::createFromFormat('U', '1548648501')->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('user', [
           'login' => 'admin'
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190127_063524_insert_user_admin cannot be reverted.\n";

        return false;
    }
    */
}
