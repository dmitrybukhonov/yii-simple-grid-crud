<?php

use yii\db\Migration;

class m231204_170644_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'middle_name' => $this->string(),
            'last_name' => $this->string(),
            'gender' => $this->smallInteger(),
            'is_deleted' => $this->boolean()->defaultValue(false),
            'birth_date' => $this->timestamp(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client}}');
    }
}
