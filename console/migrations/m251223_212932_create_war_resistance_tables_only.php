<?php

use yii\db\Migration;

/**
 * Class m251223_212932_create_war_resistance_tables_only
 */
class m251223_212932_create_war_resistance_tables_only extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // 创建战役信息表
        $this->createTable('{{%war_campaign}}', [
            'campaign_id' => $this->primaryKey(),
            'campaign_name' => $this->string(100)->notNull(),
            'start_time' => $this->string(20),
            'end_time' => $this->string(20),
            'location' => $this->string(200),
            'warring_parties' => $this->text(),
            'result' => $this->string(500),
            'description' => $this->text(),
        ], $tableOptions);

        // 创建英雄信息表
        $this->createTable('{{%hero_info}}', [
            'hero_id' => $this->primaryKey(),
            'hero_name' => $this->string(50)->notNull(),
            'native_place' => $this->string(200),
            'deed' => $this->text(),
            'army' => $this->string(200),
            'campaign_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // 创建史料文献表
        $this->createTable('{{%historical_doc}}', [
            'doc_id' => $this->primaryKey(),
            'doc_name' => $this->string(100)->notNull(),
            'doc_type' => $this->string(50),
            'doc_summary' => $this->text(),
            'related_campaign_id' => $this->integer(),
        ], $tableOptions);

        // 创建图片资源表
        $this->createTable('{{%image_resource}}', [
            'img_id' => $this->primaryKey(),
            'img_url' => $this->string(500),
            'img_desc' => $this->string(500),
            'related_id' => $this->integer(),
            'upload_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        // 创建留言表
        $this->createTable('{{%message_board}}', [
            'msg_id' => $this->primaryKey(),
            'nickname' => $this->string(50)->notNull(),
            'content' => $this->text()->notNull(),
            'msg_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        // 创建权限表
        $this->createTable('{{%permission}}', [
            'perm_id' => $this->primaryKey(),
            'member_id' => $this->integer()->notNull(),
            'perm_level' => $this->string(50)->notNull(),
            'perm_desc' => $this->string(200),
        ], $tableOptions);

        // 创建发布信息表
        $this->createTable('{{%publish_info}}', [
            'publish_id' => $this->primaryKey(),
            'title' => $this->string(200)->notNull(),
            'content' => $this->text()->notNull(),
            'publish_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'publisher_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // 创建文物信息表
        $this->createTable('{{%relic_info}}', [
            'relic_id' => $this->primaryKey(),
            'relic_name' => $this->string(200)->notNull(),
            'relic_type' => $this->string(100),
            'age' => $this->string(50),
            'collection_place' => $this->string(200),
            'description' => $this->text(),
        ], $tableOptions);

        // 创建数据统计表
        $this->createTable('{{%data_statistics}}', [
            'stat_id' => $this->primaryKey(),
            'stat_type' => $this->string(100)->notNull(),
            'stat_year' => $this->integer(),
            'stat_count' => $this->integer(),
        ], $tableOptions);

        // 创建团队信息表
        $this->createTable('{{%team_info}}', [
            'team_id' => $this->primaryKey(),
            'team_name' => $this->string(200)->notNull(),
            'project_topic' => $this->string(500),
            'division_work' => $this->text(),
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        // 创建成员信息表
        $this->createTable('{{%member_info}}', [
            'member_id' => $this->primaryKey(),
            'member_name' => $this->string(100)->notNull(),
            'student_id' => $this->string(50)->notNull(),
            'duty' => $this->string(100),
            'introduction' => $this->text(),
        ], $tableOptions);

        // 添加外键约束
        $this->addForeignKey(
            'fk_hero_campaign_id',
            '{{%hero_info}}',
            'campaign_id',
            '{{%war_campaign}}',
            'campaign_id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_doc_campaign_id',
            '{{%historical_doc}}',
            'related_campaign_id',
            '{{%war_campaign}}',
            'campaign_id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_hero_campaign_id', '{{%hero_info}}');
        $this->dropForeignKey('fk_doc_campaign_id', '{{%historical_doc}}');
        $this->dropTable('{{%member_info}}');
        $this->dropTable('{{%team_info}}');
        $this->dropTable('{{%data_statistics}}');
        $this->dropTable('{{%relic_info}}');
        $this->dropTable('{{%publish_info}}');
        $this->dropTable('{{%permission}}');
        $this->dropTable('{{%message_board}}');
        $this->dropTable('{{%image_resource}}');
        $this->dropTable('{{%historical_doc}}');
        $this->dropTable('{{%hero_info}}');
        $this->dropTable('{{%war_campaign}}');
    }
}