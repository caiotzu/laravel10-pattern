<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden">
  <div class="mobile-menu-bar">
    <a href="{{ route('revenda.home.index') }}" class="flex mr-auto">
      <img alt="Pattern laravel 10" class="w-6" src="{{ asset('build/assets/images/github.png') }}">
    </a>
    <a href="javascript:;" class="mobile-menu-toggler">
      <i data-lucide="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i>
    </a>
  </div>
  <div class="scrollable">
    <a href="javascript:;" class="mobile-menu-toggler">
      <i data-lucide="x-circle" class="w-8 h-8 text-white transform -rotate-90"></i>
    </a>
    <ul class="scrollable__content py-2">
      @foreach ($revenda_side_menu as $menuKey => $menu)
        @if ($menu == 'devider')
          <li class="menu__devider my-6"></li>
        @else
          <li>
            <a href="{{ isset($menu['route_name']) ? route($menu['route_name'], $menu['params']) : 'javascript:;' }}" class="{{ $revenda_first_level_active_index == $menuKey ? 'menu menu--active' : 'menu' }}">
              <div class="menu__icon">
                <i data-lucide="{{ $menu['icon'] }}"></i>
              </div>
              <div class="menu__title">
                {{ $menu['title'] }}
                @if (isset($menu['sub_menu']))
                  <i data-lucide="chevron-down" class="menu__sub-icon {{ $revenda_first_level_active_index == $menuKey ? 'transform rotate-180' : '' }}"></i>
                @endif
              </div>
            </a>
            @if (isset($menu['sub_menu']))
              <ul class="{{ $revenda_first_level_active_index == $menuKey ? 'menu__sub-open' : '' }}">
                @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu)
                  <li>
                    <a href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], $subMenu['params']) : 'javascript:;' }}" class="{{ $revenda_second_level_active_index == $subMenuKey ? 'menu menu--active' : 'menu' }}">
                      <div class="menu__icon">
                        <i data-lucide="activity"></i>
                      </div>
                      <div class="menu__title">
                        {{ $subMenu['title'] }}
                        @if (isset($subMenu['sub_menu']))
                          <i data-lucide="chevron-down" class="menu__sub-icon {{ $revenda_second_level_active_index == $subMenuKey ? 'transform rotate-180' : '' }}"></i>
                        @endif
                      </div>
                    </a>
                    @if (isset($subMenu['sub_menu']))
                      <ul class="{{ $revenda_second_level_active_index == $subMenuKey ? 'menu__sub-open' : '' }}">
                        @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
                          <li>
                            <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params']) : 'javascript:;' }}" class="{{ $revenda_third_level_active_index == $lastSubMenuKey ? 'menu menu--active' : 'menu' }}">
                              <div class="menu__icon">
                                <i data-lucide="zap"></i>
                              </div>
                              <div class="menu__title">{{ $lastSubMenu['title'] }}</div>
                            </a>
                          </li>
                        @endforeach
                      </ul>
                    @endif
                  </li>
                @endforeach
              </ul>
            @endif
          </li>
        @endif
      @endforeach
    </ul>
  </div>
</div>
<!-- END: Mobile Menu -->
