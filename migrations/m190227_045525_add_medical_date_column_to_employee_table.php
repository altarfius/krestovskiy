<?php

use yii\db\Migration;

/**
 * Handles adding medical_date to table `{{%employee}}`.
 */
class m190227_045525_add_medical_date_column_to_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%employee}}', 'medical_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%employee}}', 'medical_date');
    }
}
