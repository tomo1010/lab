                <!-- 🔔 ログイン促すモーダル -->
                <!-- ✅ モーダル（ログインフォーム付き） -->



                <div x-show="showLoginModal"
                    x-cloak
                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">

                    <div
                        class="relative bg-white p-6 rounded shadow-lg w-full max-w-md"
                        @click.outside="showLoginModal = false">

                        <!-- ✖️ 閉じるボタン -->
                        <button
                            @click="showLoginModal = false"
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl"
                            aria-label="閉じる">
                            &times;
                        </button>

                        <!-- モーダル見出し -->
                        <h2 class="text-xl font-bold mb-4 text-center">ログインしてください</h2>

                        <!-- ✅ ログインフォーム（Laravel Breeze形式） -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full"
                                    type="email" name="email"
                                    :value="old('email')"
                                    required autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="block mt-1 w-full"
                                    type="password" name="password"
                                    required autocomplete="current-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember me -->
                            <div class="block mt-4">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me" type="checkbox"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        name="remember">
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                </label>
                            </div>

                            <!-- ボタン行 -->
                            <div class="flex items-center justify-between mt-6">
                                @if (Route::has('password.request'))
                                <a class="text-sm text-gray-600 underline hover:text-gray-900"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                                @endif

                                <x-primary-button>
                                    {{ __('Log in') }}
                                </x-primary-button>
                            </div>

                            <!-- ✅ 新規登録リンク（モーダル下に表示） -->
                            <div class="mt-4 text-center">
                                <span class="text-sm text-gray-600">アカウントをお持ちでない方は</span>
                                <a href="{{ route('register') }}" class="text-sm text-blue-600 underline hover:text-blue-800">
                                    新規登録はこちら
                                </a>
                            </div>
                        </form>

                    </div>
                </div>