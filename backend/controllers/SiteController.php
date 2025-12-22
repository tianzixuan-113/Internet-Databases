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
        $totalRelics = RelicInfo::find()->count();
        $totalDocs = HistoricalDoc::find()->count();
        $totalHeroes = HeroInfo::find()->count();
        $totalCampaigns = WarCampaign::find()->count();
        $totalMembers = MemberInfo::find()->count();
        $totalTeams = TeamInfo::find()->count();

        $totalMessages = MessageBoard::find()->count();

        $today = date('Y-m-d 00:00:00');
        $sevenDaysAgo = date('Y-m-d 00:00:00', strtotime('-7 days'));
        $messagesLast7 = MessageBoard::find()
            ->where(['>=', 'msg_time', $sevenDaysAgo])
            ->count();
        $messagesPrev7 = MessageBoard::find()
            ->where(['<', 'msg_time', $sevenDaysAgo])
            ->andWhere(['>=', 'msg_time', date('Y-m-d 00:00:00', strtotime('-14 days'))])
            ->count();

        $messageTrend = $messagesPrev7 > 0
            ? round((($messagesLast7 - $messagesPrev7) / $messagesPrev7) * 100)
            : null;

        $campaignByYear = (new \yii\db\Query())
            ->select(["year" => "YEAR(start_time)", 'count' => 'COUNT(*)'])
            ->from(WarCampaign::tableName())
            ->groupBy(["YEAR(start_time)"])
            ->orderBy(["YEAR(start_time)" => SORT_ASC])
            ->all();

        $heroByCampaign = (new \yii\db\Query())
            ->select(['campaign_id', 'count' => 'COUNT(*)'])
            ->from(HeroInfo::tableName())
            ->groupBy(['campaign_id'])
            ->orderBy(['campaign_id' => SORT_ASC])
            ->all();

        return $this->render('index', [
            'totals' => [
                'relics' => $totalRelics,
                'docs' => $totalDocs,
                'heroes' => $totalHeroes,
                'campaigns' => $totalCampaigns,
                'members' => $totalMembers,
                'teams' => $totalTeams,
                'messages' => $totalMessages,
            ],
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
