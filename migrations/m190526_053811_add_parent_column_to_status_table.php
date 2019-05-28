<?php

use yii\db\Migration;

/**
 * Handles adding parent to table `{{%status}}`.
 */
class m190526_053811_add_parent_column_to_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%status}}', 'parent', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%status}}', 'parent');
    }
}
