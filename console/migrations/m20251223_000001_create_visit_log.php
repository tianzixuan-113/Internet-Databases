<?php
use yii\db\Migration;

class m20251223_000001_create_visit_log extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%visit_log}}', [
            'id' => $this->primaryKey(),
            'route' => $this->string(128)->notNull(),
            'url' => $this->string(2048)->notNull(),
            'user_id' => $this->integer()->null(),
            'ip' => $this->string(45)->null(),
            'ua' => $this->string(255)->null(),
            'referer' => $this->string(2048)->null(),
            'created_at' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB');

        $this->createIndex('idx_visit_log_route', '{{%visit_log}}', 'route');
        $this->createIndex('idx_visit_log_user', '{{%visit_log}}', 'user_id');
        $this->createIndex('idx_visit_log_created', '{{%visit_log}}', 'created_at');
    }

    public function safeDown()
    {
        $this->dropTable('{{%visit_log}}');
    }
}
