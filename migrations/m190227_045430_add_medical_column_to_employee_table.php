<?php

use yii\db\Migration;

/**
 * Handles adding medical to table `{{%employee}}`.
 */
class m190227_045430_add_medical_column_to_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%employee}}', 'medical', $this->tinyInteger(1)->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%employee}}', 'medical');
    }
}
