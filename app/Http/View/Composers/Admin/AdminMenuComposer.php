<?php

namespace App\Http\View\Composers\Admin;

use Illuminate\View\View;
use App\Main\Admin\TopMenu;
use App\Main\Admin\SideMenu;
use App\Main\Admin\SimpleMenu;

class AdminMenuComposer
{
  /**
   * Bind data to the view.
   *
   * @param  View  $view
   * @return void
   */
  public function compose(View $view) {
    if (!is_null(request()->route())) {
      $pageName = request()->route()->getName();
      $layout = $this->layout($view);
      $activeMenu = $this->activeMenu($pageName, $layout);

      $view->with('admin_top_menu', TopMenu::menu());
      $view->with('admin_side_menu', SideMenu::menu());
      $view->with('admin_simple_menu', SimpleMenu::menu());
      $view->with('admin_first_level_active_index', $activeMenu['first_level_active_index']);
      $view->with('admin_second_level_active_index', $activeMenu['second_level_active_index']);
      $view->with('admin_third_level_active_index', $activeMenu['third_level_active_index']);
      $view->with('page_name', $pageName);
      $view->with('layout', $layout);
    }
  }

  /**
   * Specify used layout.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function layout($view) {
    if (isset($view->layout)) {
      return $view->layout;
    } else if (request()->has('layout')) {
      return request()->query('layout');
    }

    return 'side-menu';
  }

  /**
   * Determine active menu & submenu.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function activeMenu($pageName, $layout) {
    $firstLevelActiveIndex = '';
    $secondLevelActiveIndex = '';
    $thirdLevelActiveIndex = '';

    if ($layout == 'top-menu') {
      foreach (TopMenu::menu() as $menuKey => $menu) {
        if (isset($menu['route_name']) && ($menu['route_name'] == $pageName || in_array($pageName, $menu['other_route'])) && empty($firstPageName)) {
          $firstLevelActiveIndex = $menuKey;
        }

        if (isset($menu['sub_menu'])) {
          foreach ($menu['sub_menu'] as $subMenuKey => $subMenu) {
            if (isset($subMenu['route_name']) && ($subMenu['route_name'] == $pageName || in_array($pageName, $subMenu['other_route'])) && $menuKey != 'menu-layout' && empty($secondPageName)) {
              $firstLevelActiveIndex = $menuKey;
              $secondLevelActiveIndex = $subMenuKey;
            }

            if (isset($subMenu['sub_menu'])) {
              foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu) {
                if (isset($lastSubMenu['route_name']) && ($lastSubMenu['route_name'] == $pageName) || in_array($pageName, $lastSubMenu['other_route'])) {
                  $firstLevelActiveIndex = $menuKey;
                  $secondLevelActiveIndex = $subMenuKey;
                  $thirdLevelActiveIndex = $lastSubMenuKey;
                }
              }
            }
          }
        }
      }
    } else if ($layout == 'simple-menu') {
      foreach (SimpleMenu::menu() as $menuKey => $menu) {
        if ($menu !== 'devider' && isset($menu['route_name']) && ($menu['route_name'] == $pageName || in_array($pageName, $menu['other_route'])) && empty($firstPageName)) {
          $firstLevelActiveIndex = $menuKey;
        }

        if (isset($menu['sub_menu'])) {
          foreach ($menu['sub_menu'] as $subMenuKey => $subMenu) {
            if (isset($subMenu['route_name']) && ($subMenu['route_name'] == $pageName || in_array($pageName, $subMenu['other_route'])) && $menuKey != 'menu-layout' && empty($secondPageName)) {
              $firstLevelActiveIndex = $menuKey;
              $secondLevelActiveIndex = $subMenuKey;
            }

            if (isset($subMenu['sub_menu'])) {
              foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu) {
                if (isset($lastSubMenu['route_name']) && ($lastSubMenu['route_name'] == $pageName || in_array($pageName, $lastSubMenu['other_route']))) {
                  $firstLevelActiveIndex = $menuKey;
                  $secondLevelActiveIndex = $subMenuKey;
                  $thirdLevelActiveIndex = $lastSubMenuKey;
                }
              }
            }
          }
        }
      }
    } else {
      foreach (SideMenu::menu() as $menuKey => $menu) {
        if ($menu !== 'devider' && isset($menu['route_name']) && ($menu['route_name'] == $pageName || in_array($pageName, $menu['other_route'])) && empty($firstPageName)) {
          $firstLevelActiveIndex = $menuKey;
        }

        if (isset($menu['sub_menu'])) {
          foreach ($menu['sub_menu'] as $subMenuKey => $subMenu) {
            if (isset($subMenu['route_name']) && ($subMenu['route_name'] == $pageName || in_array($pageName, $subMenu['other_route'])) && $menuKey != 'menu-layout' && empty($secondPageName)) {
              $firstLevelActiveIndex = $menuKey;
              $secondLevelActiveIndex = $subMenuKey;
            }

            if (isset($subMenu['sub_menu'])) {
              foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu) {
                if (isset($lastSubMenu['route_name']) && ($lastSubMenu['route_name'] == $pageName || in_array($pageName, $lastSubMenu['other_route']))) {
                  $firstLevelActiveIndex = $menuKey;
                  $secondLevelActiveIndex = $subMenuKey;
                  $thirdLevelActiveIndex = $lastSubMenuKey;
                }
              }
            }
          }
        }
      }
    }

    return [
      'first_level_active_index' => $firstLevelActiveIndex,
      'second_level_active_index' => $secondLevelActiveIndex,
      'third_level_active_index' => $thirdLevelActiveIndex
    ];
  }
}
