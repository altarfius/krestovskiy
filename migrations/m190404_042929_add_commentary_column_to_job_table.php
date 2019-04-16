<?php

use yii\db\Migration;

/**
 * Handles adding commentary to table `{{%job}}`.
 */
class m190404_042929_add_commentary_column_to_job_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%job}}', 'commentary', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%job}}', 'commentary');
    }
}
