<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\TeamInfo;
use common\models\MemberInfo;
use common\models\RelicInfo;
use common\models\WarCampaign;
use common\models\HeroInfo;
use common\models\HistoricalDoc;
use common\models\ImageResource;
use common\models\MessageBoard;
use common\models\PublishInfo;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $cache = \Yii::$app->cache;

        $totals = $cache->getOrSet('dashboard_totals', function() {
            return [
                'relics' => RelicInfo::find()->count(),
                'docs' => HistoricalDoc::find()->count(),
                'heroes' => HeroInfo::find()->count(),
                'campaigns' => WarCampaign::find()->count(),
                'members' => MemberInfo::find()->count(),
                'teams' => TeamInfo::find()->count(),
                'messages' => MessageBoard::find()->count(),
            ];
        }, 300);

        $sevenDaysAgo = date('Y-m-d 00:00:00', strtotime('-7 days'));
        $messagesLast7 = $cache->getOrSet('dashboard_messages_last7', function() use ($sevenDaysAgo) {
            return MessageBoard::find()->where(['>=', 'msg_time', $sevenDaysAgo])->count();
        }, 300);
        $messagesPrev7 = $cache->getOrSet('dashboard_messages_prev7', function() use ($sevenDaysAgo) {
            $prevStart = date('Y-m-d 00:00:00', strtotime('-14 days'));
            return MessageBoard::find()->where(['<', 'msg_time', $sevenDaysAgo])->andWhere(['>=', 'msg_time', $prevStart])->count();
        }, 300);
        $messageTrend = $messagesPrev7 > 0 ? round((($messagesLast7 - $messagesPrev7) / $messagesPrev7) * 100) : null;

        // 仅取最近 10 年的战役统计，避免过长的柱形图，提高加载速度
        $campaignByYear = $cache->getOrSet('dashboard_campaign_by_year_10', function() {
            $query = (new \yii\db\Query())
                ->select(["year" => "YEAR(start_time)", 'count' => 'COUNT(*)'])
                ->from(WarCampaign::tableName())
                ->groupBy(["YEAR(start_time)"])
                ->orderBy(["YEAR(start_time)" => SORT_DESC])
                ->limit(10);
            $rows = $query->all();
            // 翻转成升序显示（从老到新）
            return array_reverse($rows);
        }, 300);

        // 英雄数按战役取 Top 10，避免横轴过长
        $heroByCampaign = $cache->getOrSet('dashboard_hero_by_campaign_top10', function() {
            return (new \yii\db\Query())
                ->select(['campaign_id', 'count' => 'COUNT(*)'])
                ->from(HeroInfo::tableName())
                ->groupBy(['campaign_id'])
                ->orderBy(['count' => SORT_DESC])
                ->limit(10)
                ->all();
        }, 300);

        return $this->render('index', [
            'totals' => $totals,
            'messagesLast7' => $messagesLast7,
            'messageTrend' => $messageTrend,
            'campaignByYear' => $campaignByYear,
            'heroByCampaign' => $heroByCampaign,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
