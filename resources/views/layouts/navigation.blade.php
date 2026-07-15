@php
    $user = auth()->user();
    $sidebarLinks = $user->isAdmin()
        ? [
            ['label' => 'Data Peserta Absensi', 'href' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard'), 'code' => 'DP'],
            ['label' => 'Laporan PDF & Excel', 'href' => route('admin.reports.index'), 'active' => request()->routeIs('admin.reports.*'), 'code' => 'LP'],
            ['label' => 'Profile', 'href' => route('profile.edit'), 'active' => request()->routeIs('profile.*'), 'code' => 'PR'],
        ]
        : [
            ['label' => 'Absen Pagi', 'href' => route('attendances.morning'), 'active' => request()->routeIs('attendances.morning'), 'code' => 'PG'],
            ['label' => 'Absen Sore', 'href' => route('attendances.evening'), 'active' => request()->routeIs('attendances.evening'), 'code' => 'SR'],
            ['label' => 'Data Absensi Saya', 'href' => route('attendances.history'), 'active' => request()->routeIs('attendances.history'), 'code' => 'DA'],
            ['label' => 'Profile', 'href' => route('profile.edit'), 'active' => request()->routeIs('profile.*'), 'code' => 'PR'],
        ];
@endphp

<nav x-data="kknShell()" x-on:keydown.escape.window="sidebarOpen = false; timeOpen = false" class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-3">
            <div class="flex min-w-0 items-center gap-3">
                <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-600 text-sm font-bold text-white">
                        KKN
                    </div>
                    <div class="hidden min-w-0 sm:block">
                        <div class="truncate text-sm font-bold leading-5 text-slate-950">Absensi KKN</div>
                        <div class="truncate text-xs font-medium capitalize text-slate-500">{{ $user->role }}</div>
                    </div>
                </a>
            </div>

            <div class="hidden min-w-0 flex-1 items-center justify-center md:flex">
                <button type="button"
                        x-on:click="timeOpen = ! timeOpen"
                        class="relative inline-flex min-w-[280px] items-center justify-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-orange-300 hover:bg-orange-50 hover:text-orange-700">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-white text-orange-600 shadow-sm">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                        </svg>
                    </span>
                    <span class="text-left">
                        <span class="block text-xs font-bold uppercase tracking-wide text-slate-500" x-text="dateLine">Tanggal</span>
                        <span class="block text-sm font-extrabold text-slate-950" x-text="clockLine">Jam</span>
                    </span>

                    <div x-cloak
                         x-show="timeOpen"
                         x-transition
                         x-on:click.outside="timeOpen = false"
                         class="absolute left-1/2 top-full mt-3 w-[340px] -translate-x-1/2 rounded-2xl border border-slate-200 bg-white p-5 text-left text-slate-800 shadow-xl">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-orange-600">Tanggal, Kalender & Jam</p>
                        <div class="mt-4 grid grid-cols-[92px_1fr] gap-4">
                            <div class="rounded-2xl border border-orange-100 bg-orange-50 p-4 text-center">
                                <p class="text-xs font-extrabold uppercase tracking-wider text-orange-700" x-text="monthLine">Bulan</p>
                                <p class="mt-1 text-4xl font-black leading-none text-orange-600" x-text="dayNumber">00</p>
                                <p class="mt-1 text-xs font-bold text-orange-700" x-text="yearLine">Tahun</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm font-extrabold text-slate-950" x-text="fullDate">-</p>
                                <p class="mt-2 text-3xl font-black tracking-tight text-slate-950" x-text="clockWithSeconds">-</p>
                                <p class="mt-2 text-xs font-semibold text-slate-500">Waktu mengikuti perangkat pengguna.</p>
                            </div>
                        </div>
                    </div>
                </button>
            </div>

            <div class="flex min-w-0 items-center justify-end gap-3">
                <div class="hidden min-w-0 text-right lg:block">
                    <div class="truncate text-sm font-bold text-slate-950">{{ $user->name }}</div>
                    <div class="truncate text-xs font-medium text-slate-500">{{ $user->structureLabel() }}</div>
                </div>

                <a href="{{ route('profile.edit') }}" class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-slate-200 bg-orange-50 text-sm font-bold uppercase text-orange-700 transition hover:border-orange-300">
                    @if($user->photo_url)
                        <img src="{{ $user->photo_url }}" alt="Foto profil {{ $user->name }}" class="h-full w-full object-cover">
                    @else
                        <span>{{ $user->initials() }}</span>
                    @endif
                </a>

                <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                    @csrf
                    <button class="rounded-xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-orange-700">
                        Logout
                    </button>
                </form>

                <button type="button"
                        x-on:click="sidebarOpen = true"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 transition hover:border-orange-300 hover:bg-orange-50 hover:text-orange-700"
                        aria-label="Buka menu kanan">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="md:hidden">
            <button type="button"
                    x-on:click="timeOpen = ! timeOpen"
                    class="mb-3 flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-semibold text-slate-700">
                <span x-text="dateLine">Tanggal</span>
                <span class="text-slate-300">•</span>
                <span x-text="clockLine">Jam</span>
            </button>

            <div x-cloak
                 x-show="timeOpen"
                 x-transition
                 x-on:click.outside="timeOpen = false"
                 class="mb-3 rounded-2xl border border-slate-200 bg-white p-4 text-slate-800 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-orange-600">Tanggal, Kalender & Jam</p>
                <div class="mt-3 flex items-center gap-3">
                    <div class="rounded-2xl border border-orange-100 bg-orange-50 px-4 py-3 text-center">
                        <p class="text-xs font-extrabold uppercase text-orange-700" x-text="monthLine">Bulan</p>
                        <p class="text-3xl font-black text-orange-600" x-text="dayNumber">00</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-950" x-text="fullDate">-</p>
                        <p class="mt-1 text-2xl font-black text-slate-950" x-text="clockWithSeconds">-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-cloak x-show="sidebarOpen" class="fixed inset-0 z-50">
        <div x-show="sidebarOpen"
             x-transition.opacity
             x-on:click="sidebarOpen = false"
             class="absolute inset-0 bg-slate-950/40"></div>

        <aside x-show="sidebarOpen"
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="translate-x-full opacity-0"
               x-transition:enter-end="translate-x-0 opacity-100"
               x-transition:leave="transition ease-in duration-150"
               x-transition:leave-start="translate-x-0 opacity-100"
               x-transition:leave-end="translate-x-full opacity-0"
               class="absolute right-0 top-0 flex h-full w-[300px] max-w-[88vw] flex-col overflow-y-auto border-l border-slate-200 bg-white p-5 shadow-2xl">
            <div class="mb-6 flex items-start justify-between gap-4">
                <div class="flex min-w-0 items-center gap-3">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-orange-100 text-sm font-bold text-orange-700">
                        @if($user->photo_url)
                            <img src="{{ $user->photo_url }}" alt="Foto profil {{ $user->name }}" class="h-full w-full object-cover">
                        @else
                            <span>{{ $user->initials() }}</span>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <div class="truncate text-base font-bold text-slate-950">{{ $user->name }}</div>
                        <div class="truncate text-xs font-medium text-slate-500">{{ $user->structureLabel() }}</div>
                    </div>
                </div>

                <button type="button" x-on:click="sidebarOpen = false" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-bold text-slate-600 hover:bg-slate-50">
                    ✕
                </button>
            </div>

            <div class="mb-4 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-orange-600">Menu</p>
                <p class="mt-1 text-sm font-medium text-slate-600">Navigasi absensi dan data peserta.</p>
            </div>

            <div class="space-y-1.5">
                @foreach($sidebarLinks as $link)
                    <a href="{{ $link['href'] }}"
                       class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold transition {{ $link['active'] ? 'bg-orange-600 text-white' : 'text-slate-700 hover:bg-orange-50 hover:text-orange-700' }}">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg {{ $link['active'] ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }} text-xs font-bold">{{ $link['code'] }}</span>
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </div>

            <div class="mt-auto pt-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full rounded-xl bg-slate-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-orange-700">
                        Logout
                    </button>
                </form>
            </div>
        </aside>
    </div>
</nav>

<script>
    function kknShell() {
        return {
            sidebarOpen: false,
            timeOpen: false,
            now: new Date(),
            get dateLine() {
                return this.now.toLocaleDateString('id-ID', {
                    weekday: 'short',
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                });
            },
            get clockLine() {
                return this.now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                });
            },
            get fullDate() {
                return this.now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric',
                });
            },
            get clockWithSeconds() {
                return this.now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                });
            },
            get dayNumber() {
                return this.now.toLocaleDateString('id-ID', { day: '2-digit' });
            },
            get monthLine() {
                return this.now.toLocaleDateString('id-ID', { month: 'long' });
            },
            get yearLine() {
                return this.now.toLocaleDateString('id-ID', { year: 'numeric' });
            },
            init() {
                setInterval(() => this.now = new Date(), 1000);
            },
        }
    }
</script>
