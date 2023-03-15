<!-- BEGIN: Layout Switcher-->
<div class="shadow-md fixed bottom-0 right-0 box border rounded-full h-12 px-5 flex items-center justify-center z-50 mb-10 mr-[34rem]">
  <div class="mr-4 hidden sm:block text-slate-600 dark:text-slate-200">Layout Scheme</div>

  <a href="{{ route('layout-scheme-switcher', ['layout_scheme' => 'default']) }}" class="block w-8 h-8 cursor-pointer bg-indigo-400 rounded-full border-4 mr-1 hover:border-slate-200 {{ $layout_scheme =='default' ? 'border-slate-300 dark:border-darkmode-800/80' : 'border-white dark:border-darkmode-600' }}">
  </a>
  <span class="mr-1">Side Menu</span>

  <a href="{{ route('layout-scheme-switcher', ['layout_scheme' => 'simple-menu']) }}" class="block w-8 h-8 cursor-pointer bg-indigo-400 rounded-full border-4 mr-1 hover:border-slate-200 {{ $layout_scheme =='simple-menu' ? 'border-slate-300 dark:border-darkmode-800/80' : 'border-white dark:border-darkmode-600' }}"></a>
  <span class="mr-1">Simple Menu</span>

  <a href="{{ route('layout-scheme-switcher', ['layout_scheme' => 'top-menu']) }}" class="block w-8 h-8 cursor-pointer bg-indigo-400 rounded-full border-4 mr-1 hover:border-slate-200 {{ $layout_scheme =='top-menu' ? 'border-slate-300 dark:border-darkmode-800/80' : 'border-white dark:border-darkmode-600' }}"></a>
  <span class="mr-1">Top menu</span>
</div>
<!-- END: Layout Switcher-->
