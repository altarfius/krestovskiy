<?php

use yii\db\Migration;

/**
 * Handles adding nationality_id to table `{{%employee}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%nationality}}`
 */
class m190224_054220_add_nationality_id_column_to_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%employee}}', 'nationality_id', $this->integer());

        // creates index for column `nationality_id`
        $this->createIndex(
            '{{%idx-employee-nationality_id}}',
            '{{%employee}}',
            'nationality_id'
        );

        // add foreign key for table `{{%nationality}}`
        $this->addForeignKey(
            '{{%fk-employee-nationality_id}}',
            '{{%employee}}',
            'nationality_id',
            '{{%nationality}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%nationality}}`
        $this->dropForeignKey(
            '{{%fk-employee-nationality_id}}',
            '{{%employee}}'
        );

        // drops index for column `nationality_id`
        $this->dropIndex(
            '{{%idx-employee-nationality_id}}',
            '{{%employee}}'
        );

        $this->dropColumn('{{%employee}}', 'nationality_id');
    }
}
