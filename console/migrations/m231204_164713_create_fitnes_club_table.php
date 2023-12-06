<?php

use yii\db\Migration;

class m231204_164713_create_fitnes_club_table extends Migration
{
    private $tableName = '{{%fitnes_club}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'address' => $this->string(),
            'is_published' => $this->boolean()->defaultValue(false),
            'is_deleted' => $this->boolean()->defaultValue(false),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-fitnes_club-is_published', $this->tableName, 'is_published');
        $this->createIndex('idx-fitnes_club-is_deleted', $this->tableName, 'is_deleted');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fitnes_club}}');
    }
}
