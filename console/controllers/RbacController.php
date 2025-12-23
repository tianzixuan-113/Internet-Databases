<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\rbac\ManagerInterface;
use common\models\User;

class RbacController extends Controller
{
    // 初始化角色与权限：admin / editor / user
    public function actionInit()
    {
        /** @var ManagerInterface $auth */
        $auth = Yii::$app->authManager;

        // 确保 RBAC 文件目录存在（针对 PhpManager 文件存储）
        foreach (['itemFile','assignmentFile','ruleFile'] as $prop) {
            if (property_exists($auth, $prop)) {
                $file = $auth->{$prop};
                if (is_string($file)) {
                    $path = Yii::getAlias($file);
                    $dir = dirname($path);
                    if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
                }
            }
        }

        // 清理旧数据（可选，生产慎用）
        // $auth->removeAll();

        // 权限
        $accessBackend = $auth->getPermission('accessBackend');
        if ($accessBackend === null) {
            $accessBackend = $auth->createPermission('accessBackend');
            $accessBackend->description = '访问后台';
            $auth->add($accessBackend);
        }

        $manageContent = $auth->getPermission('manageContent');
        if ($manageContent === null) {
            $manageContent = $auth->createPermission('manageContent');
            $manageContent->description = '管理内容（文献、图片、战役等）';
            $auth->add($manageContent);
        }

        $postMessage = $auth->getPermission('postMessage');
        if ($postMessage === null) {
            $postMessage = $auth->createPermission('postMessage');
            $postMessage->description = '发布留言/互动';
            $auth->add($postMessage);
        }

        // 角色
        $userRole = $auth->getRole('user');
        if ($userRole === null) { $userRole = $auth->createRole('user'); $auth->add($userRole); }
        if (!$auth->hasChild($userRole, $postMessage)) $auth->addChild($userRole, $postMessage);

        $editor = $auth->getRole('editor');
        if ($editor === null) { $editor = $auth->createRole('editor'); $auth->add($editor); }
        if (!$auth->hasChild($editor, $manageContent)) $auth->addChild($editor, $manageContent);
        if (!$auth->hasChild($editor, $userRole)) $auth->addChild($editor, $userRole);

        $admin = $auth->getRole('admin');
        if ($admin === null) { $admin = $auth->createRole('admin'); $auth->add($admin); }
        if (!$auth->hasChild($admin, $accessBackend)) $auth->addChild($admin, $accessBackend);
        if (!$auth->hasChild($admin, $editor)) $auth->addChild($admin, $editor);

        // 将首个用户赋予 admin（若没有任何 admin 分配）
        $hasAdmin = false;
        if (method_exists($auth, 'getUserIdsByRole')) {
            $ids = $auth->getUserIdsByRole('admin');
            $hasAdmin = !empty($ids);
        }
        if (!$hasAdmin) {
            $firstUser = User::find()->orderBy(['id' => SORT_ASC])->one();
            if ($firstUser) {
                $auth->assign($admin, (int)$firstUser->id);
                $this->stdout("Assigned 'admin' to user #{$firstUser->id}\n");
            }
        }
        $this->stdout("RBAC initialized.\n");
    }
}
