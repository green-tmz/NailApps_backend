<?php
return [
    'permissions' => [
        'auth.view' => 'Просмотр блога',
        'auth.create' => 'Создание записей',
        'auth.edit' => 'Редактирование записей',
        'auth.delete' => 'Удаление записей',
    ],

    'roles' => [
        'admin' => [
            'blog.view',
            'blog.create',
            'blog.edit',
            'blog.delete',
        ],
        'master' => [
            'blog.view',
            'blog.create',
            'blog.edit',
        ],
    ],
];
