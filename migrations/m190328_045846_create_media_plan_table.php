<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%media_plan}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m190328_045846_create_media_plan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%media_plan}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date(),
            'value' => $this->decimal(11,2)->notNull()->defaultValue(0),
            'create_time' => $this->datetime()->notNull(),
            'create_user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `create_user_id`
        $this->createIndex(
            '{{%idx-media_plan-create_user_id}}',
            '{{%media_plan}}',
            'create_user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-media_plan-create_user_id}}',
            '{{%media_plan}}',
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
            '{{%fk-media_plan-create_user_id}}',
            '{{%media_plan}}'
        );

        // drops index for column `create_user_id`
        $this->dropIndex(
            '{{%idx-media_plan-create_user_id}}',
            '{{%media_plan}}'
        );

        $this->dropTable('{{%media_plan}}');
    }
}
