<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-orange-600">Admin Panel</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Data Peserta Absensi</h1>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                            Admin bisa mengubah absensi peserta kapan saja. Data edit dipisah menjadi tabel absen pagi dan tabel absen sore agar lebih rapi.
                        </p>
                    </div>

                    <form method="GET" class="flex flex-col gap-2 sm:flex-row">
                        <input type="date" name="date" value="{{ $date }}" class="rounded-xl border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        <button class="rounded-xl bg-orange-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-orange-700">Filter</button>
                    </form>
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

            <div class="mb-6 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div>
                    <p class="text-sm font-bold text-slate-950">Laporan tanggal {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</p>
                    <p class="text-xs font-medium text-slate-500">Unduh laporan sesuai data yang sedang ditampilkan.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.reports.pdf', ['date' => $date]) }}" class="rounded-xl bg-orange-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-orange-700">Download PDF</a>
                    <a href="{{ route('admin.reports.excel', ['date' => $date]) }}" class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-700">Download Excel</a>
                </div>
            </div>

            <div class="mb-8 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-orange-600">Laporan Ringkas</p>
                        <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Rekap Kehadiran</h2>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Tanggal {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead>
                            <tr class="bg-slate-50 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                <th class="rounded-l-xl px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Status Kehadiran Hari</th>
                                <th class="px-4 py-3">Hadir</th>
                                <th class="px-4 py-3">Izin</th>
                                <th class="px-4 py-3">Pulang</th>
                                <th class="rounded-r-xl px-4 py-3">Alfa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($summaryRows as $row)
                                <tr class="text-sm text-slate-700">
                                    <td class="px-4 py-3 font-bold text-slate-950">{{ $row['nama'] }}</td>
                                    <td class="px-4 py-3">{{ $row['status_kehadiran_hari'] }}</td>
                                    <td class="px-4 py-3 font-semibold">{{ $row['hadir'] }}</td>
                                    <td class="px-4 py-3 font-semibold">{{ $row['izin'] }}</td>
                                    <td class="px-4 py-3 font-semibold">{{ $row['pulang'] }}</td>
                                    <td class="px-4 py-3 font-semibold">{{ $row['alfa'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @php
                $periodTables = [
                    [
                        'title' => 'Tabel Absen Pagi',
                        'eyebrow' => 'Edit Absensi Pagi',
                        'caption' => 'Jam peserta 05.00 - 11.00 WIB. Admin bisa edit kapan saja.',
                        'period' => \App\Models\Attendance::PERIOD_PAGI,
                        'rows' => $morningAttendances,
                    ],
                    [
                        'title' => 'Tabel Absen Sore',
                        'eyebrow' => 'Edit Absensi Sore',
                        'caption' => 'Jam peserta 13.00 - 22.00 WIB. Admin bisa edit kapan saja, termasuk status Pulang.',
                        'period' => \App\Models\Attendance::PERIOD_SORE,
                        'rows' => $eveningAttendances,
                    ],
                ];
            @endphp

            <div class="grid gap-6 xl:grid-cols-2">
                @foreach($periodTables as $table)
                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-orange-600">{{ $table['eyebrow'] }}</p>
                                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">{{ $table['title'] }}</h2>
                                <p class="mt-1 text-sm text-slate-500">{{ $table['caption'] }}</p>
                            </div>
                            <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-bold text-orange-700">{{ $table['rows']->count() }} data</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-[780px] divide-y divide-slate-200">
                                <thead>
                                    <tr class="bg-slate-50 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                        <th class="rounded-l-xl px-4 py-3">Peserta</th>
                                        <th class="px-4 py-3">Jam</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Catatan</th>
                                        <th class="rounded-r-xl px-4 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($table['rows'] as $attendance)
                                        <tr class="align-middle text-sm text-slate-700">
                                            <td class="px-4 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-orange-100 text-xs font-bold text-orange-700">
                                                        @if($attendance->user->photo_url)
                                                            <img src="{{ $attendance->user->photo_url }}" alt="Foto profil {{ $attendance->user->name }}" class="h-full w-full object-cover">
                                                        @else
                                                            {{ $attendance->user->initials() }}
                                                        @endif
                                                    </div>
                                                    <div class="min-w-0">
                                                        <div class="truncate font-bold text-slate-950">{{ $attendance->user->name }}</div>
                                                        <div class="truncate text-xs font-medium text-slate-500">{{ $attendance->user->structureLabel() }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 font-semibold text-slate-800">{{ $attendance->attendance_at?->format('H:i') ?? 'Belum absen' }}</td>
                                            <td class="px-4 py-4">
                                                <form method="POST" action="{{ route('admin.attendances.update', $attendance) }}" class="contents">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" class="w-full rounded-xl border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-800 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                                        @foreach(\App\Models\Attendance::statusesForPeriod($table['period']) as $value => $text)
                                                            <option value="{{ $value }}" @selected(old('status', $attendance->status) === $value)>{{ $text }}</option>
                                                        @endforeach
                                                    </select>
                                            </td>
                                            <td class="px-4 py-4">
                                                    <input type="text" name="note" value="{{ old('note', $attendance->note) }}" class="w-full rounded-xl border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500" placeholder="Catatan admin">
                                            </td>
                                            <td class="px-4 py-4">
                                                    <button class="rounded-xl bg-slate-950 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-orange-700">Simpan</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-6 text-center text-sm font-semibold text-amber-700">Belum ada data untuk periode ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
