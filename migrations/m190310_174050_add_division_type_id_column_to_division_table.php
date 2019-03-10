<?php

use yii\db\Migration;

/**
 * Handles adding division_type_id to table `{{%division}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%division_type}}`
 */
class m190310_174050_add_division_type_id_column_to_division_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%division}}', 'division_type_id', $this->integer());

        // creates index for column `division_type_id`
        $this->createIndex(
            '{{%idx-division-division_type_id}}',
            '{{%division}}',
            'division_type_id'
        );

        // add foreign key for table `{{%division_type}}`
        $this->addForeignKey(
            '{{%fk-division-division_type_id}}',
            '{{%division}}',
            'division_type_id',
            '{{%division_type}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%division_type}}`
        $this->dropForeignKey(
            '{{%fk-division-division_type_id}}',
            '{{%division}}'
        );

        // drops index for column `division_type_id`
        $this->dropIndex(
            '{{%idx-division-division_type_id}}',
            '{{%division}}'
        );

        $this->dropColumn('{{%division}}', 'division_type_id');
    }
}
