<?php

use yii\db\Migration;

/**
 * Class m190213_051011_add_passport_data_to_employee_table
 */
class m190213_051011_add_passport_data_to_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%employee}}', 'passport_type', $this->string()->defaultValue(1));
        $this->addColumn('{{%employee}}', 'passport_number', $this->string());
        $this->addColumn('{{%employee}}', 'passport_issued', $this->string());
        $this->addColumn('{{%employee}}', 'passport_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%employee}}', 'passport_type');
        $this->dropColumn('{{%employee}}', 'passport_number');
        $this->dropColumn('{{%employee}}', 'passport_issued');
        $this->dropColumn('{{%employee}}', 'passport_date');

        return true;
    }

}
