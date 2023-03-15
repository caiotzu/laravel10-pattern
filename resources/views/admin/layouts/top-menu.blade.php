
@include('../admin/layouts/components/mobile-menu')
@include('../admin/layouts/components/top-bar', ['class' => 'top-bar-boxed--top-menu'])
<!-- BEGIN: Top Menu -->
<nav class="top-nav">
  <ul>
    @foreach ($admin_top_menu as $menuKey => $menu)
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
      @if($access)
        <li>
          <a href="{{ isset($menu['route_name']) ? route($menu['route_name'], $menu['params']) : 'javascript:;' }}" class="{{ $admin_first_level_active_index == $menuKey ? 'top-menu top-menu--active' : 'top-menu' }}">
            <div class="top-menu__icon">
              <i data-lucide="{{ $menu['icon'] }}"></i>
            </div>
            <div class="top-menu__title">
              {{ $menu['title'] }}
              @if (isset($menu['sub_menu']))
                <i data-lucide="chevron-down" class="top-menu__sub-icon"></i>
              @endif
            </div>
          </a>
          @if (isset($menu['sub_menu']))
            <ul class="{{ $admin_first_level_active_index == $menuKey ? 'top-menu__sub-open' : '' }}">
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
                    <a href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], $subMenu['params']) : 'javascript:;' }}" class="top-menu">
                      <div class="top-menu__icon">
                        <i data-lucide="{{ $subMenu['icon'] }}"></i>
                      </div>
                      <div class="top-menu__title">
                        {{ $subMenu['title'] }}
                        @if (isset($subMenu['sub_menu']))
                          <i data-lucide="chevron-down" class="top-menu__sub-icon"></i>
                        @endif
                      </div>
                    </a>
                    @if (isset($subMenu['sub_menu']))
                      <ul class="{{ $admin_second_level_active_index == $subMenuKey ? 'top-menu__sub-open' : '' }}">
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
                              <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params']) : 'javascript:;' }}" class="top-menu">
                                <div class="top-menu__icon">
                                  <i data-lucide="{{ $subMenu['icon'] }}"></i>
                                </div>
                                <div class="top-menu__title">{{ $lastSubMenu['title'] }}</div>
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
    @endforeach
  </ul>
</nav>
<!-- END: Top Menu -->
<!-- BEGIN: Content -->
<div class="content content--top-nav">
  @yield('adminContent')
</div>
<!-- END: Content -->
