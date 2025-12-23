<?php

use yii\db\Migration;

/**
 * Class m251223_175855_fill_war_resistance_data
 */
class m251223_175855_fill_war_resistance_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // 插入数据统计
        $this->batchInsert('{{%data_statistics}}', 
            ['stat_type', 'stat_year', 'stat_count'], 
            [
                ['战役年份统计', 1937, 5],
                ['战役年份统计', 1938, 3],
                ['战役年份统计', 1939, 2],
                ['战役年份统计', 1940, 1],
                ['英雄籍贯统计', 1937, 12],
                ['英雄籍贯统计', 1938, 8],
                ['英雄籍贯统计', 1939, 6],
                ['英雄籍贯统计', 1940, 4],
            ]
        );

        // 插入英雄信息
        $this->batchInsert('{{%hero_info}}', 
            ['hero_id', 'hero_name', 'native_place', 'deed', 'army', 'campaign_id'], 
            [
                [1, '杨靖宇', '河南省确山县', '东北抗日联军主要创建者和领导人之一，长期在东北坚持抗日斗争，直至壮烈牺牲', '东北抗日联军', 1],
                [2, '赵一曼', '四川省宜宾县', '在东北抗日战争中被俘，面对日军酷刑宁死不屈，英勇就义', '东北抗日联军', 1],
                [3, '张自忠', '山东省临清县', '在枣宜会战中率部与日军激战，壮烈殉国，是抗日战争中牺牲的最高级别将领之一', '国民革命军第33集团军', 3],
                [4, '左权', '湖南省醴陵县', '八路军高级将领，在反"扫荡"作战中指挥部队突围时牺牲', '八路军', 4],
                [5, '戴安澜', '安徽省无为县', '中国远征军第200师师长，在缅甸作战中英勇牺牲', '中国远征军', 5],
                [6, '佟麟阁', '河北省高阳县', '七七事变爆发后率部抵抗日军进攻，壮烈殉国', '国民革命军第29军', 6],
                [7, '赵登禹', '山东省菏泽县', '七七事变中率部与日军作战，英勇牺牲', '国民革命军第29军', 6],
                [8, '吉鸿昌', '河南省扶沟县', '察哈尔抗日同盟军主要领导人之一，积极组织抗日活动', '察哈尔抗日同盟军', 7],
            ]
        );

        // 插入史料文献
        $this->batchInsert('{{%historical_doc}}', 
            ['doc_name', 'doc_type', 'doc_summary', 'related_campaign_id'], 
            [
                ['平型关大捷战报', '战报', '八路军第115师在平型关取得首战大捷的详细战报，记录了战斗经过和战果', 1],
                ['台儿庄战役总结报告', '总结报告', '第五战区司令长官李宗仁关于台儿庄战役的总结报告，详述了战役部署和胜利意义', 2],
                ['论持久战', '战略理论', '毛泽东关于抗日战争的战略理论著作，科学分析了抗日战争的规律和进程', null],
                ['八路军抗战八年总结', '总结报告', '八路军总部对抗战八年的全面总结，包括战绩和经验', null],
                ['新四军抗战历程', '历史文献', '新四军在华中地区抗战的详细记录', null],
            ]
        );

        // 插入图片资源
        $this->batchInsert('{{%image_resource}}', 
            ['img_url', 'img_desc', 'related_id'], 
            [
                ['https://example.com/images/pingxingguan.jpg', '平型关大捷战场遗址', 1],
                ['https://example.com/images/taierzhuang.jpg', '台儿庄战役战场复原图', 2],
                ['https://example.com/images/yangjingyu.jpg', '抗日英雄杨靖宇肖像', 1],
                ['https://example.com/images/zhaoyiman.jpg', '抗日英雄赵一曼肖像', 2],
                ['https://example.com/images/zhangzizhong.jpg', '抗日将领张自忠肖像', 3],
                ['https://example.com/images/zuoguang.jpg', '抗日将领左权肖像', 4],
                ['https://example.com/images/daianlan.jpg', '抗日将领戴安澜肖像', 5],
                ['https://example.com/images/junxunjuntuan.jpg', '八路军军徽与臂章', 1],
                ['https://example.com/images/wuqijuhui.jpg', '抗日游击队缴获的日军武器', 3],
                ['https://example.com/images/yumin.jpg', '民众支援抗战的场景', 2],
            ]
        );

        // 插入留言
        $this->batchInsert('{{%message_board}}', 
            ['nickname', 'content', 'msg_time'], 
            [
                ['铭记历史', '致敬抗日英雄，珍惜和平生活', '2025-12-20 10:30:00'],
                ['爱国青年', '感谢你们做的抗战主题网站，让我了解了很多历史', '2025-12-20 11:45:23'],
                ['历史爱好者', '这些珍贵的史料值得我们永远铭记', '2025-12-20 14:20:11'],
                ['和平守护者', '勿忘国耻，振兴中华', '2025-12-20 16:15:37'],
                ['学生', '通过这个网站学到了很多课堂之外的知识', '2025-12-21 09:05:42'],
                ['老一辈', '我们这代人对这段历史有深刻记忆，希望年轻人永远记住', '2025-12-21 12:30:18'],
                ['教师', '很好的教育平台，会推荐给我的学生们', '2025-12-21 15:40:55'],
                ['研究者', '史料详实，感谢你们的整理工作', '2025-12-22 08:22:10'],
            ]
        );

        // 插入权限
        $this->batchInsert('{{%permission}}', 
            ['member_id', 'perm_level', 'perm_desc'], 
            [
                [1, '编辑', '可编辑前端相关资讯'],
                [2, '管理员', '可管理所有内容'],
                [3, '编辑', '可编辑数据库相关资料'],
            ]
        );

        // 插入资讯
        $this->batchInsert('{{%publish_info}}', 
            ['title', 'content', 'publish_time', 'publisher_id'], 
            [
                ['纪念抗战胜利80周年', '今年是抗日战争胜利80周年，我们要铭记历史，缅怀先烈，珍爱和平，开创未来。', '2025-10-25 10:00:00', 2],
                ['新增珍贵史料', '我们最近收集了一批关于抗日战争的珍贵史料，包括战地日记、电报、照片等，丰富了网站内容。', '2025-11-05 14:30:00', 3],
                ['英雄人物事迹更新', '更新了多位抗日英雄的生平事迹，增加了他们鲜为人知的感人故事。', '2025-11-15 09:15:00', 1],
                ['文物展示区上线', '新增了文物展示区，展示了抗战时期的武器、生活用品、文献等珍贵文物。', '2025-11-22 16:45:00', 2],
                ['互动留言功能开放', '现在您可以在这个平台上留下对英雄的敬意和对和平的祝愿。', '2025-12-01 11:20:00', 1],
            ]
        );

        // 插入文物
        $this->batchInsert('{{%relic_info}}', 
            ['relic_name', 'relic_type', 'age', 'collection_place', 'description'], 
            [
                ['八路军军装', '服装', '1937-1945', '中国人民革命军事博物馆', '八路军战士穿过的军装，见证了艰苦卓绝的抗战岁月'],
                ['抗日游击队使用的大刀', '武器', '1937-1945', '中国人民抗日战争纪念馆', '抗日游击队使用的大刀，刀刃锋利，是"大刀向鬼子头上砍去"的象征'],
                ['缴获的日军指挥刀', '武器', '1937-1945', '中国人民革命军事博物馆', '在某次战斗中缴获的日军指挥刀，见证了中国军队的英勇作战'],
                ['抗战时期的收音机', '通信设备', '1937-1945', '中国人民抗日战争纪念馆', '抗战时期用于收听战况和宣传的收音机'],
                ['抗日根据地发行的货币', '货币', '1937-1945', '中国国家博物馆', '抗日根据地为稳定经济发行的货币，具有重要的历史价值'],
                ['战地日记', '文献', '1937-1945', '中国人民抗日战争纪念馆', '某位抗日战士的战地日记，记录了战斗生活和思想感受'],
                ['抗战时期的传单', '文献', '1937-1945', '中国国家博物馆', '宣传抗日、动员民众的传单，反映了当时的政治宣传'],
                ['民兵使用的老式步枪', '武器', '1937-1945', '中国人民革命军事博物馆', '抗日民兵使用的老式步枪，体现了全民抗战的特点'],
            ]
        );

        // 插入战役
        $this->batchInsert('{{%war_campaign}}', 
            ['campaign_name', 'start_time', 'end_time', 'location', 'warring_parties', 'result', 'description'], 
            [
                ['武汉会战', '1938-06-11', '1938-10-27', '湖北省武汉市', '中国第五、第九战区部队 vs 日本第二、第十一军', '中国军队战略撤退，但消耗了日军大量有生力量', '武汉会战是抗日战争期间规模最大的一次会战，标志着抗日战争进入战略相持阶段。'],
                ['长沙会战', '1939-09-14', '1942-01-06', '湖南省长沙市', '中国第九战区部队 vs 日本第十一军', '中国军队取得三次会战胜利，沉重打击了日军', '长沙会战是中国军队在抗日战争相持阶段取得的较大胜利之一。'],
                ['百团大战', '1940-08-20', '1941-01-24', '华北地区', '八路军 vs 日军华北方面军', '八路军取得大规模破袭战胜利', '百团大战是全民族抗战以来八路军在华北发动的规模最大、持续时间最长的一次带战略性进攻的战役。'],
                ['淞沪会战', '1937-08-13', '1937-11-26', '上海市', '中国第三战区部队 vs 日本上海派遣军', '中国军队撤退，但粉碎了日军三个月灭亡中国的计划', '淞沪会战是中日双方在抗日战争中的第一场大型会战，也是整个中日战争中进行的规模最大、战斗最惨烈的一场战役。'],
                ['徐州会战', '1938-01-26', '1938-05-19', '江苏省徐州市', '中国第五战区部队 vs 日本华北方面军', '中国军队在台儿庄取得胜利，但最终失守徐州', '徐州会战是中日双方在华东地区进行的一次大规模战役，其中台儿庄战役是会战的重要组成部分。'],
            ]
        );

        // 插入用户
        $this->batchInsert('{{%user}}', 
            ['username', 'auth_key', 'password_hash', 'email', 'status', 'created_at', 'updated_at'], 
            [
                ['admin', 'admin_auth_key', '$2y$13$uQFJmN2.HFf6o1z8L4sZNeH5aMm5Qp0K7zY1yZ8L4sZNeH5aMm5Qp', 'admin@example.com', 10, 1609334400, 1609334400],
                ['guosida', 'guosida_auth_key', '$2y$13$uQFJmN2.HFf6o1z8L4sZNeH5aMm5Qp0K7zY1yZ8L4sZNeH5aMm5Qp', 'guosida@example.com', 10, 1609334400, 1609334400],
                ['zhangdu', 'zhangdu_auth_key', '$2y$13$uQFJmN2.HFf6o1z8L4sZNeH5aMm5Qp0K7zY1yZ8L4sZNeH5aMm5Qp', 'zhangdu@example.com', 10, 1609334400, 1609334400],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%data_statistics}}', ['stat_type' => ['战役年份统计', '英雄籍贯统计']]);
        $this->delete('{{%hero_info}}', ['hero_id' => [1, 2, 3, 4, 5, 6, 7, 8]]);
        $this->delete('{{%historical_doc}}', ['doc_name' => ['平型关大捷战报', '台儿庄战役总结报告', '论持久战', '八路军抗战八年总结', '新四军抗战历程']]);
        $this->delete('{{%image_resource}}', ['img_url' => ['https://example.com/images/pingxingguan.jpg', 'https://example.com/images/taierzhuang.jpg', 'https://example.com/images/yangjingyu.jpg', 'https://example.com/images/zhaoyiman.jpg', 'https://example.com/images/zhangzizhong.jpg', 'https://example.com/images/zuoguang.jpg', 'https://example.com/images/daianlan.jpg', 'https://example.com/images/junxunjuntuan.jpg', 'https://example.com/images/wuqijuhui.jpg', 'https://example.com/images/yumin.jpg']]);
        $this->delete('{{%message_board}}', ['nickname' => ['铭记历史', '爱国青年', '历史爱好者', '和平守护者', '学生', '老一辈', '教师', '研究者']]);
        $this->delete('{{%permission}}', ['member_id' => [1, 2, 3]]);
        $this->delete('{{%publish_info}}', ['publish_id' => [1, 2, 3, 4, 5]]);
        $this->delete('{{%relic_info}}', ['relic_name' => ['八路军军装', '抗日游击队使用的大刀', '缴获的日军指挥刀', '抗战时期的收音机', '抗日根据地发行的货币', '战地日记', '抗战时期的传单', '民兵使用的老式步枪']]);
        $this->delete('{{%war_campaign}}', ['campaign_name' => ['武汉会战', '长沙会战', '百团大战', '淞沪会战', '徐州会战']]);
        $this->delete('{{%user}}', ['username' => ['admin', 'guosida', 'zhangdu']]);
    }
}