<?php

namespace App\Main\Admin;

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
          'COMPANYGROUP_MENU',
        ],
        'sub_menu' => [
          'companyGroups' => [
            'icon' => 'layers',
            'route_name' => 'admin.companyGroups.index',
            'other_route' => [
              'admin.companyGroups.create',
              'admin.companyGroups.edit',
            ],
            'params' => [],
            'title' => 'Grupos Empresas',
            'permissions' => [
              'COMPANYGROUP_MENU',
            ]
          ],
          'companies' => [
            'icon' => 'building',
            'route_name' => 'admin.companies.index',
            'other_route' => [
              'admin.companies.create',
              'admin.companies.edit',
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
            'route_name' => 'admin.users.index',
            'other_route' => [
              'admin.users.create',
              'admin.users.edit',
            ],
            'params' => [],
            'title' => 'Usuários',
            'permissions' => [
              'USER_MENU'
            ]
          ],
          'permissions' => [
            'icon' => 'unlock',
            'route_name' => 'admin.permissions.index',
            'other_route' => [
              'admin.permissions.create',
              'admin.permissions.edit',
            ],
            'params' => [],
            'title' => 'Permissões',
            'permissions' => [
              'PERMISSION_MENU'
            ]
          ],
          'system' => [
            'icon' => 'monitor',
            'route_name' => 'admin.systems.index',
            'other_route' => [
              'admin.systems.create',
              'admin.systems.edit',
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
