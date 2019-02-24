<?php

use yii\db\Migration;

/**
 * Handles adding object_id to table `{{%employee}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%division}}`
 */
class m190224_043537_add_division_id_column_to_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%employee}}', 'division_id', $this->integer());

        // creates index for column `division_id`
        $this->createIndex(
            '{{%idx-employee-division_id}}',
            '{{%employee}}',
            'division_id'
        );

        // add foreign key for table `{{%division}}`
        $this->addForeignKey(
            '{{%fk-employee-division_id}}',
            '{{%employee}}',
            'division_id',
            '{{%division}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%division}}`
        $this->dropForeignKey(
            '{{%fk-employee-division_id}}',
            '{{%employee}}'
        );

        // drops index for column `division_id`
        $this->dropIndex(
            '{{%idx-employee-division_id}}',
            '{{%employee}}'
        );

        $this->dropColumn('{{%employee}}', 'division_id');
    }
}
