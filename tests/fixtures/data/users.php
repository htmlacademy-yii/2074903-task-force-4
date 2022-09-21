<?php

use omarinina\domain\valueObjects\UserId;

return [
    'user1' => [
        'uuid' => UserId::create(),
        'email' => 'hello@ya.ru',
        'name' => 'Mr Duck',
        'password' => 'top-secret',
        'role' => 2,
        'city' => 2
    ],
    'user2' => [
        'uuid' => UserId::create(),
        'email' => 'bye@ya.ru',
        'name' => 'Catty',
        'password' => 'just-secret',
        'role' => 1,
        'city' => 2
    ],
    'user3' => [
        'uuid' => UserId::create(),
        'email' => 'wtf@ya.ru',
        'name' => 'Strange',
        'password' => 'secret',
        'role' => 2,
        'city' => 1
    ]
];
