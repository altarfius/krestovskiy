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
//        $this->insert('user', [
//            'login' => 'admin',
//            'surname' => 'Натовский',
//            'name' => 'Дмитрий',
//            'hash' => '1ecd5abcec35d73c5919e3c286e8116d49e3374f',
//            'create_time' => DateTime::createFromFormat('U', '1548648501')->format('Y-m-d H:i:s'),
//        ]);
        $this->batchInsert('category_type', [
            'name'
        ], [
            ['Кухня'],
            ['Зал'],
            ['Подсобка']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190128_043913_insert_data_to_category_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190128_043913_insert_data_to_category_type cannot be reverted.\n";

        return false;
    }
    */
}
