<?php

return [

  'super_admin' => [
    'enabled' => true,
    'name' => 'super_admin',
  ],

  'permissions' => [
    'auto_create' => true,
    'exclude' => [
      'viewAny',
      'deleteAny',
      'view',
      'update',
      'create',
      'delete'
    ],
  ],

  'register' => [
    'styles' => [],
    'beforeCoreScripts' => [],
    'scripts' => [],
    'pages' => [
      OpenSynergic\Core\Filament\Pages\Profile::class,
    ],
    'resources' => [
      OpenSynergic\Core\Filament\Resources\RoleResource::class,
      OpenSynergic\Core\Filament\Resources\UserResource::class,
    ]
  ],


];
