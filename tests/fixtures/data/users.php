<?php

use omarinina\domain\valueObjects\UniqueIdentification;


return [
    'user1' => [
        'uuid' => UniqueIdentification::createInst(),
        'email' => 'hello@ya.ru',
        'name' => 'Mr Duck',
        'password' => 'top-secret',
        'role' => 2,
        'city' => 2
    ],
    'user2' => [
        'uuid' => UniqueIdentification::createInst(),
        'email' => 'bye@ya.ru',
        'name' => 'Catty',
        'password' => 'just-secret',
        'role' => 1,
        'city' => 2
    ],
    'user3' => [
        'uuid' => UniqueIdentification::createInst(),
        'email' => 'wtf@ya.ru',
        'name' => 'Strange',
        'password' => 'secret',
        'role' => 2,
        'city' => 1
    ]
];
