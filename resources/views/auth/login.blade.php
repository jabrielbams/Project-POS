<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-xl font-bold text-gray-900 tracking-tight">Selamat Datang</h2>
        <p class="text-sm text-gray-500 mt-1.5">Masuk ke akun Anda untuk melanjutkan</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[13px] font-semibold text-gray-700 mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                autocomplete="username" placeholder="nama@email.com"
                class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-[13px] font-semibold text-gray-700">Password</label>
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                placeholder="••••••••"
                class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center pt-1 gap-2">
            <input id="remember_me" type="checkbox" name="remember"
                class="w-4 h-4 gap-3 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-offset-0 transition-colors" />
            <label for="remember_me" class="ml-2.5 text-sm text-gray-600 select-none cursor-pointer">Tetap login selama 30 hari</label>
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full flex items-center justify-center gap-2 px-4 py-3 text-sm font-bold text-white bg-blue-600 rounded-xl">
            Masuk
        </button>
    </form>
</x-guest-layout>