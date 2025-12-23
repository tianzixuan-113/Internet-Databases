<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
        ],
        'authManager' => [
            'class' => 'yii\\rbac\\PhpManager',
            // 将 RBAC 数据存储为文件，避免新增数据库表
            'itemFile' => '@common/runtime/rbac/items.php',
            'assignmentFile' => '@common/runtime/rbac/assignments.php',
            'ruleFile' => '@common/runtime/rbac/rules.php',
        ],
    ],
];
