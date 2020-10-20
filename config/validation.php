<?php

$REQUIRESTRING = ['required', 'string'];

return [
    'auth' => [
        'signup' => [
            'validation' => [
                'first_name' => $REQUIRESTRING,
                'last_name' => $REQUIRESTRING,
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => $REQUIRESTRING,
                'device_name' => $REQUIRESTRING,
            ],
            'fields' => [
                'first_name', 'last_name', 'email', 'password'
            ],
        ],
        'login' => [
            'validation' => [
                'email' => ['required', 'email', 'exists:users,email'],
                'password' => $REQUIRESTRING,
                'device_name' => $REQUIRESTRING,
            ],
            'fields' => [
                'email', 'password'
            ],
        ]
    ]
];