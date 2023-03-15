<!-- BEGIN: Layout Switcher-->
<div class="shadow-md fixed bottom-0 right-0 box border rounded-full h-10 px-1 flex items-center justify-center z-50 mb-10 mr-5">

<div class="intro-x dropdown w-8 h-8">
  <div class="dropdown-toggle flex items-center justify-center" role="button" aria-expanded="false" data-tw-toggle="dropdown">
    <i data-lucide="more-vertical" class="pt-2"></i>
  </div>
  <div class="dropdown-menu w-56">
    <ul class="dropdown-content before:block before:absolute before:bg-black before:inset-0 before:rounded-md before:z-[-1] text-slate-600 dark:text-slate-200">
      <li class="p-2">
        <div class="text-slate-600 dark:text-slate-200 font-medium mb-2">Layout Scheme</div>
        <div class="flex content-between mb-2">
          <a href="{{ route('layout-scheme-switcher', ['layout_scheme' => 'default']) }}" class="block w-8 h-8 cursor-pointer bg-indigo-400 rounded-full border-4 mr-1 hover:border-slate-200 {{ $layout_scheme =='default' ? 'border-slate-300 dark:border-darkmode-800/80' : 'border-white dark:border-darkmode-600' }}">
          </a>
          <span class="ml-1 mt-0.5 inline-block">Side Menu</span>
        </div>
        <div class="flex content-between mb-2">
          <a href="{{ route('layout-scheme-switcher', ['layout_scheme' => 'simple-menu']) }}" class="block w-8 h-8 cursor-pointer bg-indigo-400 rounded-full border-4 mr-1 hover:border-slate-200 {{ $layout_scheme =='simple-menu' ? 'border-slate-300 dark:border-darkmode-800/80' : 'border-white dark:border-darkmode-600' }}"></a>
          <span class="ml-1 mt-0.5 inline-block">Simple Menu</span>
        </div>
        <div class="flex content-between mb-2">
          <a href="{{ route('layout-scheme-switcher', ['layout_scheme' => 'top-menu']) }}" class="block w-8 h-8 cursor-pointer bg-indigo-400 rounded-full border-4 mr-1 hover:border-slate-200 {{ $layout_scheme =='top-menu' ? 'border-slate-300 dark:border-darkmode-800/80' : 'border-white dark:border-darkmode-600' }}"></a>
          <span class="ml-1 mt-0.5 inline-block">Top menu</span>
        </div>
      </li>
      <li>
        <hr class="dropdown-divider dark:border-white/[0.08]">
      </li>
      <li class="p-2">
        <div class="text-slate-600 dark:text-slate-200 font-medium mb-2">Color Scheme</div>
        <a href="{{ route('color-scheme-switcher', ['color_scheme' => 'default']) }}" class="block w-8 h-8 cursor-pointer bg-cyan-900 rounded-full border-4 mr-1 hover:border-slate-200 {{ $color_scheme =='default' ? 'border-slate-300 dark:border-darkmode-800/80' : 'border-white dark:border-darkmode-600' }}"></a>
        <a href="{{ route('color-scheme-switcher', ['color_scheme' => 'theme-1']) }}" class="block w-8 h-8 cursor-pointer bg-blue-800 rounded-full border-4 mr-1 hover:border-slate-200 {{ $color_scheme =='theme-1' ? 'border-slate-300 dark:border-darkmode-800/80' : 'border-white dark:border-darkmode-600' }}"></a>
        <a href="{{ route('color-scheme-switcher', ['color_scheme' => 'theme-2']) }}" class="block w-8 h-8 cursor-pointer bg-blue-900 rounded-full border-4 mr-1 hover:border-slate-200 {{ $color_scheme =='theme-2' ? 'border-slate-300 dark:border-darkmode-800/80' : 'border-white dark:border-darkmode-600' }}"></a>
        <a href="{{ route('color-scheme-switcher', ['color_scheme' => 'theme-3']) }}" class="block w-8 h-8 cursor-pointer bg-emerald-900 rounded-full border-4 mr-1 hover:border-slate-200 {{ $color_scheme =='theme-3' ? 'border-slate-300 dark:border-darkmode-800/80' : 'border-white dark:border-darkmode-600' }}"></a>
        <a href="{{ route('color-scheme-switcher', ['color_scheme' => 'theme-4']) }}" class="block w-8 h-8 cursor-pointer bg-indigo-900 rounded-full border-4 hover:border-slate-200 {{ $color_scheme =='theme-4' ? 'border-slate-300 dark:border-darkmode-800/80' : 'border-white dark:border-darkmode-600' }}"></a>
      </li>
      <li>
        <hr class="dropdown-divider dark:border-white/[0.08]">
      </li>
      <li class="p-2">
        <div data-url="{{ route('dark-mode-switcher') }}" class="dark-mode-switcher">
          <div class="mr-4 text-slate-600 dark:text-slate-200 font-medium mb-2">Dark Mode</div>
          <div class="dark-mode-switcher__toggle {{ $dark_mode ? 'dark-mode-switcher__toggle--active' : '' }} border"></div>
        </div>
      </li>
    </ul>
  </div>
</div>
</div>

