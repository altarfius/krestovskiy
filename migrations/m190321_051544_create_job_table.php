<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%job}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%division}}`
 * - `{{%category}}`
 * - `{{%user}}`
 */
class m190321_051544_create_job_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%job}}', [
            'id' => $this->primaryKey(),
            'division_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'begin_date' => $this->date(),
            'end_date' => $this->date(),
            'count_opened' => $this->integer()->notNull()->defaultValue(0),
            'count_closed' => $this->integer()->notNull()->defaultValue(0),
            'count_assigned_interviews' => $this->integer()->notNull()->defaultValue(0),
            'count_conducted_interviews' => $this->integer()->notNull()->defaultValue(0),
            'count_trainees' => $this->integer()->notNull()->defaultValue(0),
            'create_time' => $this->date(),
            'create_user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `division_id`
        $this->createIndex(
            '{{%idx-job-division_id}}',
            '{{%job}}',
            'division_id'
        );

        // add foreign key for table `{{%division}}`
        $this->addForeignKey(
            '{{%fk-job-division_id}}',
            '{{%job}}',
            'division_id',
            '{{%division}}',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-job-category_id}}',
            '{{%job}}',
            'category_id'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            '{{%fk-job-category_id}}',
            '{{%job}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );

        // creates index for column `create_user_id`
        $this->createIndex(
            '{{%idx-job-create_user_id}}',
            '{{%job}}',
            'create_user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-job-create_user_id}}',
            '{{%job}}',
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
        // drops foreign key for table `{{%division}}`
        $this->dropForeignKey(
            '{{%fk-job-division_id}}',
            '{{%job}}'
        );

        // drops index for column `division_id`
        $this->dropIndex(
            '{{%idx-job-division_id}}',
            '{{%job}}'
        );

        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            '{{%fk-job-category_id}}',
            '{{%job}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-job-category_id}}',
            '{{%job}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-job-create_user_id}}',
            '{{%job}}'
        );

        // drops index for column `create_user_id`
        $this->dropIndex(
            '{{%idx-job-create_user_id}}',
            '{{%job}}'
        );

        $this->dropTable('{{%job}}');
    }
}
