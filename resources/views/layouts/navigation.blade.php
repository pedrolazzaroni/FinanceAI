<nav x-data="{ open: false }" class="bg-white/90 dark:bg-primary-900/90 backdrop-blur-xl border-b border-primary-100 dark:border-primary-800 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 sm:space-x-3 text-primary-900 dark:text-primary-100 hover:text-primary-700 dark:hover:text-primary-300 transition-colors group">
                        <x-finance-logo size="sm" class="group-hover:scale-110 transition-transform duration-300" />
                        <span class="font-semibold text-lg sm:text-xl hidden md:block">Assistente Financeiro</span>
                        <span class="font-semibold text-lg sm:text-xl md:hidden">FinanceAI</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:ml-8 lg:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <x-icons.home class="w-4 h-4" />
                        <span class="hidden lg:inline">Dashboard</span>
                    </x-nav-link>
                    <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" class="nav-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                        <x-icons.money class="w-4 h-4" />
                        <span class="hidden lg:inline">Transações</span>
                    </x-nav-link>
                    <x-nav-link :href="route('goals.index')" :active="request()->routeIs('goals.*')" class="nav-item {{ request()->routeIs('goals.*') ? 'active' : '' }}">
                        <x-icons.target class="w-4 h-4" />
                        <span class="hidden lg:inline">Metas</span>
                    </x-nav-link>
                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <x-icons.chart class="w-4 h-4" />
                        <span class="hidden lg:inline">Relatórios</span>
                    </x-nav-link>
                </div>
            </div>

            <!-- Right side items -->
            <div class="hidden sm:flex sm:items-center sm:space-x-3">
                <!-- Dark Mode Toggle -->
                <x-dark-mode-toggle />
                
                <!-- Settings Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center px-2 sm:px-3 py-2 text-sm font-medium rounded-xl text-primary-600 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-100 hover:bg-primary-50 dark:hover:bg-primary-800 focus:outline-none transition-all duration-200">
                            <div class="w-7 h-7 sm:w-8 sm:h-8 bg-primary-100 dark:bg-primary-800 rounded-full flex items-center justify-center mr-2 sm:mr-3">
                                <x-icons.user class="w-3 h-3 sm:w-4 sm:h-4 text-primary-600 dark:text-primary-400" />
                            </div>
                            <span class="hidden lg:block truncate max-w-24">{{ Auth::user()->name }}</span>
                            <x-icons.chevron-down class="w-3 h-3 sm:w-4 sm:h-4 ml-1 sm:ml-2" />
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-primary-100 dark:border-primary-800">
                            <div class="font-medium text-sm text-primary-900 dark:text-primary-100 truncate">{{ Auth::user()->name }}</div>
                            <div class="font-normal text-xs text-primary-500 dark:text-primary-400 truncate">{{ Auth::user()->email }}</div>
                        </div>
                        
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                            <x-icons.settings class="w-4 h-4 mr-3" />
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center text-danger hover:bg-red-50 dark:hover:bg-red-900/20">
                                <x-icons.logout class="w-4 h-4 mr-3" />
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile menu -->
            <div class="flex items-center space-x-2 sm:space-x-3 sm:hidden">
                <!-- Dark Mode Toggle Mobile -->
                <x-dark-mode-toggle id="dark-mode-toggle-mobile" />
                
                <!-- Hamburger -->
                <button @click="open = ! open" class="btn-icon p-2">
                    <x-icons.menu x-show="!open" class="w-5 h-5" />
                    <x-icons.x x-show="open" class="w-5 h-5" />
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="sm:hidden bg-white dark:bg-primary-900 border-t border-primary-100 dark:border-primary-800">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center space-x-3">
                <x-icons.home class="w-4 h-4" />
                <span>Dashboard</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" class="flex items-center space-x-3">
                <x-icons.money class="w-4 h-4" />
                <span>Transações</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('goals.index')" :active="request()->routeIs('goals.*')" class="flex items-center space-x-3">
                <x-icons.target class="w-4 h-4" />
                <span>Metas</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" class="flex items-center space-x-3">
                <x-icons.chart class="w-4 h-4" />
                <span>Relatórios</span>
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-primary-200 dark:border-primary-700">
            <div class="px-4 flex items-center space-x-3 mb-3">
                <div class="w-10 h-10 bg-primary-100 dark:bg-primary-800 rounded-full flex items-center justify-center">
                    <x-icons.user class="w-5 h-5 text-primary-600 dark:text-primary-400" />
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-primary-900 dark:text-primary-100 truncate">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-primary-500 dark:text-primary-400 truncate">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1 px-4">
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center space-x-3">
                    <x-icons.settings class="w-4 h-4" />
                    <span>{{ __('Profile') }}</span>
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center space-x-3 text-danger">
                        <x-icons.logout class="w-4 h-4" />
                        <span>{{ __('Log Out') }}</span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
