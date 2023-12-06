<?php

use yii\db\Migration;

class m231204_171031_fitnes_club_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fitnes_club_client}}', [
            'id' => $this->primaryKey(),
            'fitnes_club_id' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('fk_fitnes_club_client_fitnes_club', '{{%fitnes_club_client}}', 'fitnes_club_id', '{{%fitnes_club}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_fitnes_club_client_client', '{{%fitnes_club_client}}', 'client_id', '{{%client}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fitnes_club_client}}');
    }
}
