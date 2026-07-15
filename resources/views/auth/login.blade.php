<x-guest-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto flex min-h-screen max-w-6xl items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
            <div class="grid w-full overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm lg:grid-cols-[1.05fr_.95fr]">
                <section class="hidden bg-orange-600 p-10 text-white lg:flex lg:flex-col lg:justify-between">
                    <div>
                        <div class="inline-flex rounded-full bg-white/15 px-4 py-2 text-sm font-semibold">
                            Sistem Absensi KKN
                        </div>
                        <h1 class="mt-8 max-w-xl text-5xl font-bold tracking-tight">
                            Absensi peserta yang rapi, aman, dan terukur.
                        </h1>
                        <p class="mt-5 max-w-lg text-base leading-7 text-orange-50">
                            Peserta login dengan akun masing-masing. Admin dapat memantau data absensi, mengoreksi data, dan mengunduh laporan PDF atau Excel.
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div class="rounded-2xl bg-white/12 p-4">
                            <p class="text-2xl font-bold">05-11</p>
                            <p class="mt-1 text-xs font-semibold text-orange-50">Absen Pagi</p>
                        </div>
                        <div class="rounded-2xl bg-white/12 p-4">
                            <p class="text-2xl font-bold">13-22</p>
                            <p class="mt-1 text-xs font-semibold text-orange-50">Absen Sore</p>
                        </div>
                        <div class="rounded-2xl bg-white/12 p-4">
                            <p class="text-2xl font-bold">PDF</p>
                            <p class="mt-1 text-xs font-semibold text-orange-50">Excel Export</p>
                        </div>
                    </div>
                </section>

                <section class="mx-auto w-full max-w-md p-6 sm:p-10">
                    <div class="mb-8 text-center">
                        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-orange-600 text-lg font-bold text-white">
                            KKN
                        </div>
                        <h2 class="text-3xl font-bold text-slate-950">Masuk Absensi</h2>
                        <p class="mt-2 text-sm text-slate-500">Gunakan username dan password dari admin.</p>
                    </div>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <x-input-label for="username" value="Username" />
                            <x-text-input id="username" class="mt-2 block w-full rounded-xl border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                          type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" value="Password" />
                            <x-text-input id="password" class="mt-2 block w-full rounded-xl border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                          type="password" name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <label class="flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-orange-600 focus:ring-orange-500">
                            Ingat saya
                        </label>

                        <button type="submit" class="w-full rounded-xl bg-orange-600 px-5 py-3.5 font-bold text-white shadow-sm transition hover:bg-orange-700">
                            Login
                        </button>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-guest-layout>
