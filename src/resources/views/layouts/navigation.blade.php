<nav class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    {{--
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    --}}
                    <x-nav-link :href="route('quote.index')" :active="request()->routeIs('quote.index')">
                        見積もり作成
                    </x-nav-link>

                    <x-nav-link :href="route('tirecalc.index')" :active="request()->routeIs('tirecalc.index')">
                        タイヤ計算機
                    </x-nav-link>

                    <x-nav-link :href="route('agecalc.index')" :active="request()->routeIs('agecalc.index')">
                        年齢計算機
                    </x-nav-link>

                    <x-nav-link :href="route('fax.send')" :active="request()->routeIs('fax.send')">
                        FAX送付状
                    </x-nav-link>

                    <x-nav-link :href="route('fax.change')" :active="request()->routeIs('fax.change')">
                        車両入替え送付状
                    </x-nav-link>

                    <x-nav-link :href="route('label.index')" :active="request()->routeIs('label.index')">
                        ラベル印刷
                    </x-nav-link>

                    <x-nav-link :href="route('pdf.construction')" :active="request()->routeIs('pdf.construction')">
                        施工証明書
                    </x-nav-link>

                    <x-nav-link :href="route('pdf.soldHorizental')" :active="request()->routeIs('pdf.soldHorizental')">
                        売約済み（横書き）
                    </x-nav-link>


                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 relative" x-data="{ dropdownOpen: false }">
                <button @click="dropdownOpen = !dropdownOpen" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    <div>
                        @auth
                        {{ Auth::user()->name }}
                        @else
                        未ログイン
                        @endauth
                    </div>

                    <div class="ml-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>

                <!-- ドロップダウンメニュー -->
                <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50"
                    style="display: none;">

                    @auth
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                    @else
                    <x-dropdown-link :href="route('login')">
                        {{ __('Login') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('register')">
                        {{ __('Register') }}
                    </x-dropdown-link>
                    @endauth
                </div>
            </div>

            <!-- Hamburger Menu -->
            <div class="-mr-2 flex items-center sm:hidden" x-data="{ menuOpen: false }">
                <button @click="menuOpen = !menuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <!-- 開いていないときはハンバーガーアイコン -->
                        <path :class="{'hidden': menuOpen, 'inline-flex': !menuOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <!-- 開いているときは❌（閉じるアイコン） -->
                        <path :class="{'hidden': !menuOpen, 'inline-flex': menuOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12-12" />
                    </svg>
                </button>

                <!-- メニュー項目 -->
                <div x-show="menuOpen" @click.away="menuOpen = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute top-16 right-0 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50 p-2"
                    style="display: none;">
                    {{--
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    --}}
                    <x-nav-link :href="route('quote.index')" :active="request()->routeIs('quote.index')">
                        見積もり作成
                    </x-nav-link>

                    <x-nav-link :href="route('tirecalc.index')" :active="request()->routeIs('tirecalc.index')">
                        タイヤ計算機
                    </x-nav-link>

                    <x-nav-link :href="route('agecalc.index')" :active="request()->routeIs('agecalc.index')">
                        年齢計算機
                    </x-nav-link>

                    <x-nav-link :href="route('fax.send')" :active="request()->routeIs('fax.send')">
                        FAX送付状
                    </x-nav-link>

                    <x-nav-link :href="route('fax.change')" :active="request()->routeIs('fax.change')">
                        車両入替え送付状
                    </x-nav-link>

                    <x-nav-link :href="route('label.index')" :active="request()->routeIs('label.index')">
                        ラベル印刷
                    </x-nav-link>

                    <x-nav-link :href="route('pdf.construction')" :active="request()->routeIs('pdf.construction')">
                        施工証明書
                    </x-nav-link>

                    <x-nav-link :href="route('pdf.soldHorizental')" :active="request()->routeIs('pdf.soldHorizental')">
                        売約済み（横書き）
                    </x-nav-link>

                    <hr class="my-2 border-gray-200">

                    @auth
                    <div class="px-3 py-1 text-sm text-gray-700">
                        {{ Auth::user()->name }}
                    </div>
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        {{ __('Profile') }}
                    </x-nav-link>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-nav-link>
                    </form>
                    @else
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Login') }}
                    </x-nav-link>
                    <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Register') }}
                    </x-nav-link>
                    @endauth

                </div>
            </div>
        </div>
    </div>
</nav>