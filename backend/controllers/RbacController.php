<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\User;

class RbacController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [ 'allow' => true, 'roles' => ['admin'] ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'assign' => ['post'],
                    'revoke' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex($q = '', $limit = 50)
    {
        $query = User::find()->orderBy(['id' => SORT_ASC]);
        $q = trim((string)$q);
        if ($q !== '') {
            $query->andFilterWhere(['or',
                ['like', 'username', $q],
                ['like', 'email', $q],
                ['id' => ctype_digit($q) ? (int)$q : null]
            ]);
        }
        $users = $query->limit(max(1, min((int)$limit, 200)))->all();
        $auth = Yii::$app->authManager;
        $rolesByUser = [];
        foreach ($users as $u) {
            $rolesByUser[$u->id] = array_keys($auth->getRolesByUser($u->id));
        }
        return $this->render('index', [
            'users' => $users,
            'rolesByUser' => $rolesByUser,
            'q' => $q,
        ]);
    }

    public function actionAssign($id, $role)
    {
        $id = (int)$id; $role = trim((string)$role);
        $allowed = ['admin','editor','user'];
        if (!in_array($role, $allowed, true)) {
            Yii::$app->session->setFlash('error', '不支持的角色');
            return $this->redirect(['index']);
        }
        $auth = Yii::$app->authManager;
        $r = $auth->getRole($role);
        if ($r) { $auth->assign($r, $id); Yii::$app->session->setFlash('success', "已为用户 #{$id} 分配 {$role}"); }
        return $this->redirect(['index']);
    }

    public function actionRevoke($id, $role)
    {
        $id = (int)$id; $role = trim((string)$role);
        if (Yii::$app->user->id == $id && $role === 'admin') {
            Yii::$app->session->setFlash('error', '不能撤销自己的管理员角色');
            return $this->redirect(['index']);
        }
        $auth = Yii::$app->authManager;
        $r = $auth->getRole($role);
        if ($r) { $auth->revoke($r, $id); Yii::$app->session->setFlash('success', "已撤销用户 #{$id} 的 {$role}"); }
        return $this->redirect(['index']);
    }
}
