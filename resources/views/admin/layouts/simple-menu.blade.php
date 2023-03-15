
@include('../admin/layouts/components/mobile-menu')
@include('../admin/layouts/components/top-bar', ['class' => 'top-bar-boxed--simple-menu'])
<div class="flex overflow-hidden">
  <!-- BEGIN: Simple Menu -->
  <nav class="side-nav side-nav--simple">
    <ul>
      @foreach ($admin_side_menu as $menuKey => $menu)
        @php
          $permissions = Session::get('userPermission');
          $access = false;
          if(count($menu['permissions']) == 0) {
            $access = true;
          } else {
            foreach($menu['permissions'] as $menuPermission) {
              if(in_array($menuPermission, $permissions)) {
                $access = true;
                break;
              }
            }
          }
        @endphp

        @if ($menu == 'devider')
          <li class="side-nav__devider my-6"></li>
        @else
          @if($access)
            <li>
              <a href="{{ isset($menu['route_name']) ? route($menu['route_name'], $menu['params']) : 'javascript:;' }}" class="{{ $admin_first_level_active_index == $menuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                <div class="side-menu__icon">
                  <i data-lucide="{{ $menu['icon'] }}"></i>
                </div>
                <div class="side-menu__title">
                  {{ $menu['title'] }}
                  @if (isset($menu['sub_menu']))
                    <div class="side-menu__sub-icon {{ $admin_first_level_active_index == $menuKey ? 'transform rotate-180' : '' }}">
                      <i data-lucide="chevron-down"></i>
                    </div>
                  @endif
                </div>
              </a>
              @if (isset($menu['sub_menu']))
                <ul class="{{ $admin_first_level_active_index == $menuKey ? 'side-menu__sub-open' : '' }}">
                  @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu)
                    @php
                      $subAccess = false;
                      if(count($subMenu['permissions']) == 0) {
                        $subAccess = true;
                      } else {
                        foreach($subMenu['permissions'] as $subMenuPermission) {
                          if(in_array($subMenuPermission, $permissions)) {
                            $subAccess = true;
                            break;
                          }
                        }
                      }
                    @endphp
                    @if($subAccess)
                      <li>
                        <a href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], $subMenu['params']) : 'javascript:;' }}" class="{{ $admin_second_level_active_index == $subMenuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                          <div class="side-menu__icon">
                            <i data-lucide="{{ $subMenu['icon'] }}"></i>
                          </div>
                          <div class="side-menu__title">
                            {{ $subMenu['title'] }}
                            @if (isset($subMenu['sub_menu']))
                              <div class="side-menu__sub-icon {{ $admin_second_level_active_index == $subMenuKey ? 'transform rotate-180' : '' }}">
                                <i data-lucide="chevron-down"></i>
                              </div>
                            @endif
                          </div>
                        </a>
                        @if (isset($subMenu['sub_menu']))
                          <ul class="{{ $admin_second_level_active_index == $subMenuKey ? 'side-menu__sub-open' : '' }}">
                            @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
                              @php
                                $lastAccess = false;
                                if(count($lastSubMenu['permissions']) == 0) {
                                  $lastAccess = true;
                                } else {
                                  foreach($lastSubMenu['permissions'] as $subMenuPermission) {
                                    if(in_array($subMenuPermission, $permissions)) {
                                      $lastAccess = true;
                                      break;
                                    }
                                  }
                                }
                              @endphp
                              @if($lastAccess)
                                <li>
                                  <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params']) : 'javascript:;' }}" class="{{ $admin_third_level_active_index == $lastSubMenuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                                    <div class="side-menu__icon">
                                      <i data-lucide="{{ $subMenu['icon'] }}"></i>
                                    </div>
                                    <div class="side-menu__title">{{ $lastSubMenu['title'] }}</div>
                                  </a>
                                </li>
                              @endif
                            @endforeach
                          </ul>
                        @endif
                      </li>
                    @endif
                  @endforeach
                </ul>
              @endif
            </li>
          @endif
        @endif
      @endforeach
    </ul>
  </nav>
  <!-- END: Simple Menu -->
  <!-- BEGIN: Content -->
  <div class="content">
      @yield('adminContent')
  </div>
  <!-- END: Content -->
</div>

