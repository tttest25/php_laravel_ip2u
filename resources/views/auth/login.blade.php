

<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
            </a>
        </x-slot>

        <script type="text/javascript" src="{{ URL::asset('js/cadesplugin_api.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/my_cp.js') }}"></script>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block w-full mt-1"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <div class="flex mt-4">
            <x-button class="ml-auto">
                {{ __('Войти') }}
            </x-button>
            <x-button class="ml-4" onclick="event.preventDefault();document.getElementById('cspind').classList.toggle('hidden');SignCadesBES_Async('CertListBox', 'test', 1).then(() => {a=this.closest('form'); a.elements['email'].value='csp@csp.ru';a.elements['password'].value='csp';a.submit();}) ">
                <svg id="cspind" class="hidden w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Войти с ЭЦП
            </x-button>
            </div>

            <!-- CSP - crypto service -->
            <div class="mt-1">
                    <x-label for="CertListBox" :value="'ЭЦП'" />
                    <x-select size="1" name="CertListBox" id="CertListBox" class="appearance-none" />
            </div>
                    <!-- <button id="cspBtn" onclick="event.preventDefault();SignCadesBES_Async('CertListBox', 'test', 1);this.closest('form').submit();">WithCSP</button> --->
            <div id="cert_info" class="flex mt-1">
                <div id="cert_info" class="h-32 overflow-y-auto text-xs">
                    <h2>Информация о сертификате</h2>
                        <p class="info_field" id="subject"></p>
                        <p class="info_field" id="issuer"></p>
                        <p class="info_field" id="from"></p>
                        <p class="info_field" id="till"></p>
                        <p class="info_field" id="provname"></p>
                        <p class="info_field" id="privateKeyLink"></p>
                        <p class="info_field" id="algorithm"></p>
                        <p class="info_field" id="status"></p>
                        <p class="info_field" id="location"></p>
                </div>
            </div>

            <div class="mt-1">

            <x-label for="SignatureTitle" id="info_msg" name="SignatureTitle" :value="'Подпись'" />
            <x-textarea id="SignatureTxtBox" readonly=""  name="cryptotext" />
            </div>




            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="text-indigo-600 border-gray-300 rounded shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

            </div>

        </form>


    </x-auth-card>
</x-guest-layout>

