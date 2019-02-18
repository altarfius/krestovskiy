<?php

use yii\db\Migration;

/**
 * Handles adding photo to table `{{%employee}}`.
 */
class m190214_055518_add_photo_column_to_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%employee}}', 'photo', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%employee}}', 'photo');
    }
}
