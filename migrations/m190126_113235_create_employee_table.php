<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Handles the creation of table `employee`.
 */
class m190126_113235_create_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employee}}', [
            'id' => $this->primaryKey(),
            'surname' => $this->string(),
            'name' => $this->string(),
            'patronymic' => $this->string(),
            'gender' => $this->tinyInteger(1),
            'age' => $this->decimal(2),
            'phone' => $this->string(18),
            'call_type' => $this->tinyInteger(1),
            'interview_date' => $this->date(),
            'category_id' => $this->integer()->notNull(),
            'manager_id' => $this->integer()->notNull(),
            'source_id' => $this->integer()->notNull(),
            'metro_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'is_candidate' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'is_trainee' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'is_employee' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'create_user_id' => $this->integer()->notNull(),
            'update_user_id' => $this->integer()->notNull(),
            'create_time' => $this->dateTime()->notNull(),
            'update_time' => $this->dateTime()->notNull()
        ]);

        // creates index for column `create_user_id`
        $this->createIndex(
            'idx-employee-create_user_id',
            '{{%employee}}',
            'create_user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-employee-create_user_id',
            '{{%employee}}',
            'create_user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `update_user_id`
        $this->createIndex(
            'idx-employee-update_user_id',
            '{{%employee}}',
            'update_user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-employee-update_user_id',
            '{{%employee}}',
            'update_user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            'idx-employee-category_id',
            '{{%employee}}',
            'category_id'
        );

        // add foreign key for table `category`
        $this->addForeignKey(
            'fk-employee-category_id',
            '{{%employee}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );

        // creates index for column `manager_id`
        $this->createIndex(
            'idx-employee-manager_id',
            '{{%employee}}',
            'manager_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-employee-manager_id',
            '{{%employee}}',
            'manager_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `source_id`
        $this->createIndex(
            'idx-employee-source_id',
            '{{%employee}}',
            'source_id'
        );

        // add foreign key for table `source`
        $this->addForeignKey(
            'fk-employee-source_id',
            '{{%employee}}',
            'source_id',
            '{{%source}}',
            'id',
            'CASCADE'
        );


        // creates index for column `metro_id`
        $this->createIndex(
            'idx-employee-metro_id',
            '{{%employee}}',
            'metro_id'
        );

        // add foreign key for table `metro`
        $this->addForeignKey(
            'fk-employee-metro_id',
            '{{%employee}}',
            'metro_id',
            '{{%metro}}',
            'id',
            'CASCADE'
        );

        // creates index for column `status_id`
        $this->createIndex(
            'idx-employee-status_id',
            '{{%employee}}',
            'status_id'
        );

        // add foreign key for table `status`
        $this->addForeignKey(
            'fk-employee-status_id',
            '{{%employee}}',
            'status_id',
            '{{%status}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-employee-create_user_id',
            '{{%employee}}'
        );

        // drops index for column `create_user_id`
        $this->dropIndex(
            'idx-employee-create_user_id',
            '{{%employee}}'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-employee-update_user_id',
            '{{%employee}}'
        );

        // drops index for column `update_user_id`
        $this->dropIndex(
            'idx-employee-update_user_id',
            '{{%employee}}'
        );

        // drops foreign key for table `category`
        $this->dropForeignKey(
            'fk-employee-category_id',
            '{{%employee}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            'idx-employee-category_id',
            '{{%employee}}'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-employee-manager_id',
            '{{%employee}}'
        );

        // drops index for column `manager_id`
        $this->dropIndex(
            'idx-employee-manager_id',
            '{{%employee}}'
        );

        // drops foreign key for table `source`
        $this->dropForeignKey(
            'fk-employee-source_id',
            '{{%employee}}'
        );

        // drops index for column `source_id`
        $this->dropIndex(
            'idx-employee-source_id',
            '{{%employee}}'
        );

        // drops foreign key for table `metro`
        $this->dropForeignKey(
            'fk-employee-metro_id',
            '{{%employee}}'
        );

        // drops index for column `metro_id`
        $this->dropIndex(
            'idx-employee-metro_id',
            '{{%employee}}'
        );

        // drops foreign key for table `status`
        $this->dropForeignKey(
            'fk-employee-status_id',
            '{{%employee}}'
        );

        // drops index for column `status_id`
        $this->dropIndex(
            'idx-employee-status_id',
            '{{%employee}}'
        );

        $this->dropTable('{{%employee}}');

        return true;
    }
}
