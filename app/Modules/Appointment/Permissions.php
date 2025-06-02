<?php
return [
    'permissions' => [
        'appointment.view' => 'Просмотр блога',
        'appointment.create' => 'Создание записей',
        'appointment.edit' => 'Редактирование записей',
        'appointment.delete' => 'Удаление записей',
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
