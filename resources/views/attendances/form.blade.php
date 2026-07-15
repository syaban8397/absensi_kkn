<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-orange-600">Absensi {{ $periodLabel }}</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-950">Form Absensi {{ $periodLabel }}</h1>
                    <p class="mt-2 text-sm text-slate-500">
                        Tanggal {{ \Carbon\Carbon::parse($today)->translatedFormat('d F Y') }} • Jam isi {{ $windowLabel }} WIB
                    </p>
                </div>

                <div class="rounded-2xl border {{ $periodOpen ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-amber-200 bg-amber-50 text-amber-700' }} px-4 py-3">
                    <p class="text-xs font-bold uppercase tracking-wide">{{ $periodOpen ? 'Form Dibuka' : 'Di Luar Jam Absen' }}</p>
                    <p class="mt-1 text-sm font-semibold">{{ $windowMessage }}</p>
                </div>
            </div>

            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 font-semibold text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="font-semibold">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
                <form method="POST" action="{{ route('attendances.store') }}" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    @csrf
                    <input type="hidden" name="period" value="{{ $period }}">

                    <div class="mb-6 grid gap-4 md:grid-cols-3">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">Status Saat Ini</p>
                            <p class="mt-2 text-xl font-bold text-slate-950">{{ $attendance?->statusLabel() ?? 'Alfa' }}</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">Jam Tersimpan</p>
                            <p class="mt-2 text-xl font-bold text-slate-950">{{ $attendance?->attendance_at?->format('H:i') ?? '-' }}</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">Periode</p>
                            <p class="mt-2 text-xl font-bold text-slate-950">{{ $periodLabel }}</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Status Kehadiran</label>
                            <select name="status"
                                    @disabled(! $periodOpen)
                                    class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 font-semibold text-slate-800 shadow-sm focus:border-orange-500 focus:ring-orange-500 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400">
                                @foreach ($statuses as $value => $text)
                                    @php
                                        $disablePulang = $period === \App\Models\Attendance::PERIOD_SORE && $value === \App\Models\Attendance::STATUS_PULANG && ! $canPulang;
                                    @endphp
                                    <option value="{{ $value }}" @selected(old('status', $attendance?->status) === $value) @disabled($disablePulang)>
                                        {{ $text }}{{ $disablePulang ? ' - belum memenuhi syarat' : '' }}
                                    </option>
                                @endforeach
                            </select>

                            @if($period === \App\Models\Attendance::PERIOD_SORE)
                                <p class="mt-2 text-xs font-semibold {{ $canPulang ? 'text-emerald-600' : 'text-amber-700' }}">
                                    {{ $canPulang ? 'Status Pulang dapat dipilih selama masih berada pada jam absensi sore.' : $pulangMessage }}
                                </p>
                            @endif
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Catatan Opsional</label>
                            <textarea name="note"
                                      rows="4"
                                      @disabled(! $periodOpen)
                                      class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400"
                                      placeholder="Contoh: izin kegiatan desa, sakit, atau keterangan lain.">{{ old('note', $attendance?->note) }}</textarea>
                        </div>

                        <button @disabled(! $periodOpen)
                                class="w-full rounded-2xl bg-orange-600 px-5 py-3.5 font-bold text-white shadow-sm transition hover:bg-orange-700 disabled:cursor-not-allowed disabled:bg-slate-300">
                            Save Data Absen {{ $periodLabel }}
                        </button>

                        @unless($periodOpen)
                            <p class="text-center text-sm font-semibold text-slate-500">
                                Absensi yang tidak disimpan pada jam {{ $windowLabel }} akan tetap tercatat sebagai <span class="text-slate-900">Alfa</span>.
                            </p>
                        @endunless
                    </div>
                </form>

                <div class="space-y-6">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-orange-600">Identitas Peserta</p>
                        <div class="mt-4 flex items-center gap-4">
                            <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-orange-100 font-bold uppercase text-orange-700">
                                @if(auth()->user()->photo_url)
                                    <img src="{{ auth()->user()->photo_url }}" alt="Foto profil {{ auth()->user()->name }}" class="h-full w-full object-cover">
                                @else
                                    {{ auth()->user()->initials() }}
                                @endif
                            </div>
                            <div class="min-w-0">
                                <h3 class="truncate text-lg font-bold text-slate-950">{{ auth()->user()->name }}</h3>
                                <p class="truncate text-sm font-medium text-slate-500">{{ auth()->user()->structureLabel() }}</p>
                            </div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="mt-5 inline-flex rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Ubah Foto / Password
                        </a>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-orange-600">Aturan Absensi</p>
                        <div class="mt-4 space-y-3 text-sm text-slate-600">
                            <div class="flex gap-3">
                                <span class="mt-1 h-2 w-2 rounded-full bg-orange-500"></span>
                                <p>Absen pagi hanya pukul <strong>05.00 - 11.00 WIB</strong>.</p>
                            </div>
                            <div class="flex gap-3">
                                <span class="mt-1 h-2 w-2 rounded-full bg-orange-500"></span>
                                <p>Absen sore hanya pukul <strong>13.00 - 22.00 WIB</strong>.</p>
                            </div>
                            <div class="flex gap-3">
                                <span class="mt-1 h-2 w-2 rounded-full bg-orange-500"></span>
                                <p>Jika peserta tidak mengisi pada waktunya, status periode tersebut tetap <strong>Alfa</strong>.</p>
                            </div>
                            <div class="flex gap-3">
                                <span class="mt-1 h-2 w-2 rounded-full bg-orange-500"></span>
                                <p>Status Pulang harus berjarak minimal <strong>7 jam</strong> dari absen pagi.</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('attendances.history') }}" class="block rounded-2xl bg-slate-950 px-5 py-4 text-center font-bold text-white hover:bg-orange-700">
                        Lihat Data Absensi Saya
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
