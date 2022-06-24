<?php

return [
  'navigation' => [
    'label' => 'Users'
  ],
  'table' => [
    'columns' => [
      'name' => 'Name',
      'email' => 'Email',
      'role' => 'Roles'
    ],
    'filters' => [
      'role' => 'Role'
    ],
    'actions' => [
      'login_as' => 'Login As'
    ]
  ],
  'form' => [
    'field' => [
      'name' => [
        'label' => 'Name',
      ],
      'email' => [
        'label' => 'E-mail',
      ],
      'password' => [
        'label' => 'Password',
      ],
      'confirm_password' => [
        'label' => 'Confirm Password',
      ],
      'roles' => [
        'label' => 'Roles',
      ]
    ]
  ]
];
