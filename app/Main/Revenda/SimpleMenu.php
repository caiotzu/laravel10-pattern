<?php

namespace App\Main\Revenda;

class SimpleMenu {
  /**
   * List of simple menu items.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public static function menu() {
    return [
      'dashboard' => [
        'icon' => 'home',
        'title' => 'Dashboard',
        'other_route' => [],
        'permissions' => [],
      ],
      'records' => [
        'icon' => 'edit',
        'title' => 'Cadastros',
        'other_route' => [],
        'permissions' => [
          'COMPANY_MENU',
        ],
        'sub_menu' => [
          'companies' => [
            'icon' => 'building',
            'route_name' => 'revenda.companies.index',
            'other_route' => [
              'revenda.companies.create',
              'revenda.companies.edit',
            ],
            'params' => [],
            'title' => 'Empresas',
            'permissions' => [
              'COMPANY_MENU',
            ]
          ],
        ],
      ],
      'settings' => [
        'icon' => 'settings',
        'title' => 'Configurações',
        'other_route' => [],
        'permissions' => [
          'USER_MENU',
          'PERMISSION_MENU',
          'SYSTEM_MENU'
        ],
        'sub_menu' => [
          'users' => [
            'icon' => 'users',
            'route_name' => 'revenda.users.index',
            'other_route' => [
              'revenda.users.create',
              'revenda.users.edit',
            ],
            'params' => [],
            'title' => 'Usuários',
            'permissions' => [
              'USER_MENU'
            ]
          ],
          'permissions' => [
            'icon' => 'unlock',
            'route_name' => 'revenda.permissions.index',
            'other_route' => [
              'revenda.permissions.create',
              'revenda.permissions.edit',
            ],
            'params' => [],
            'title' => 'Permissões',
            'permissions' => [
              'PERMISSION_MENU'
            ]
          ],
          'system' => [
            'icon' => 'monitor',
            'route_name' => 'revenda.systems.index',
            'other_route' => [
              'revenda.systems.create',
              'revenda.systems.edit',
            ],
            'params' => [],
            'title' => 'Sistema',
            'permissions' => [
              'SYSTEM_MENU'
            ]
          ],
        ],
      ],
    ];
  }
}
