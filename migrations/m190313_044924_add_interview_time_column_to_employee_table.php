<?php

use yii\db\Migration;

/**
 * Handles adding interview_time to table `{{%employee}}`.
 */
class m190313_044924_add_interview_time_column_to_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%employee}}', 'interview_time', $this->time());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%employee}}', 'interview_time');
    }
}
