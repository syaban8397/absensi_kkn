<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-orange-600">Data Absensi Saya</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-950">History Absensi</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-500">
                    Semua data yang tampil di halaman ini hanya milik {{ auth()->user()->name }}.
                </p>
            </div>

            <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($summary as $label => $count)
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-orange-600">{{ $label }}</p>
                        <p class="mt-2 text-4xl font-bold text-slate-950">{{ $count }}</p>
                    </div>
                @endforeach
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-orange-600">Riwayat</p>
                        <h2 class="mt-1 text-2xl font-bold text-slate-950">Seluruh Riwayat Absensi</h2>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('attendances.morning') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Absen Pagi</a>
                        <a href="{{ route('attendances.evening') }}" class="rounded-xl bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700">Absen Sore</a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead>
                            <tr class="bg-slate-50 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                <th class="rounded-l-xl px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Hari</th>
                                <th class="px-4 py-3">Periode</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Jam</th>
                                <th class="rounded-r-xl px-4 py-3">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($history as $item)
                                <tr class="text-sm text-slate-700">
                                    <td class="px-4 py-3 font-semibold">{{ $item->attendance_date->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">{{ $item->attendance_date->translatedFormat('l') }}</td>
                                    <td class="px-4 py-3">{{ $item->periodLabel() }}</td>
                                    <td class="px-4 py-3">
                                        <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-bold text-orange-700">{{ $item->statusLabel() }}</span>
                                    </td>
                                    <td class="px-4 py-3">{{ $item->attendance_at?->format('H:i') ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $item->note ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada riwayat absensi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-5">
                    {{ $history->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
