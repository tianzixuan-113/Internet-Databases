<?php
return [
    'accessBackend' => [
        'type' => 2,
        'description' => '访问后台',
    ],
    'manageContent' => [
        'type' => 2,
        'description' => '管理内容（文献、图片、战役等）',
    ],
    'postMessage' => [
        'type' => 2,
        'description' => '发布留言/互动',
    ],
    'user' => [
        'type' => 1,
        'children' => [
            'postMessage',
        ],
    ],
    'editor' => [
        'type' => 1,
        'children' => [
            'manageContent',
            'user',
        ],
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'accessBackend',
            'editor',
        ],
    ],
];
