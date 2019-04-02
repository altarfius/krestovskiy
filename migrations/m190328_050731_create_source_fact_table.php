<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%source_fact}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m190328_050731_create_source_fact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%source_fact}}', [
            'id' => $this->primaryKey(),
            'source_id' => $this->integer()->notNull(),
            'date' => $this->date(),
            'value' => $this->decimal(11,2)->notNull()->defaultValue(0),
            'count_calls' => $this->integer()->notNull()->defaultValue(0),
            'count_assigned_interviews' => $this->integer()->notNull()->defaultValue(0),
            'count_conducted_interviews' => $this->integer()->notNull()->defaultValue(0),
            'create_time' => $this->datetime()->notNull(),
            'create_user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `source_id`
        $this->createIndex(
            '{{%idx-source_fact-source_id}}',
            '{{%source_fact}}',
            'source_id'
        );

        // add foreign key for table `{{%source}}`
        $this->addForeignKey(
            '{{%fk-source_fact-source_id}}',
            '{{%source_fact}}',
            'source_id',
            '{{%source}}',
            'id',
            'CASCADE'
        );

        // creates index for column `create_user_id`
        $this->createIndex(
            '{{%idx-source_fact-create_user_id}}',
            '{{%source_fact}}',
            'create_user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-source_fact-create_user_id}}',
            '{{%source_fact}}',
            'create_user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-source_fact-create_user_id}}',
            '{{%source_fact}}'
        );

        // drops index for column `create_user_id`
        $this->dropIndex(
            '{{%idx-source_fact-create_user_id}}',
            '{{%source_fact}}'
        );

        // drops foreign key for table `{{%source}}`
        $this->dropForeignKey(
            '{{%fk-source_fact-source_id}}',
            '{{%source_fact}}'
        );

        // drops index for column `source_id`
        $this->dropIndex(
            '{{%idx-source_fact-source_id}}',
            '{{%source_fact}}'
        );

        $this->dropTable('{{%source_fact}}');
    }
}
