<?php

use yii\db\Migration;

class m231204_171048_action_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%action_log}}', [
            'id' => $this->primaryKey(),
            'entity_id' => $this->integer()->notNull(),
            'entity_class' => $this->string()->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%action_log}}');
    }
}
