<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-orange-600">Dokumentasi</p>
                        <h1 class="mt-1 text-3xl font-bold text-slate-950">Laporan PDF & Excel</h1>
                        <p class="mt-2 text-sm text-slate-500">Laporan hanya menampilkan data sesuai kebutuhan rekap absensi.</p>
                    </div>
                    <form method="GET" class="flex flex-col gap-2 sm:flex-row">
                        <input type="date" name="date" value="{{ $date }}" class="rounded-xl border-slate-200 px-4 py-2.5 text-sm font-semibold focus:border-orange-500 focus:ring-orange-500">
                        <button class="rounded-xl bg-orange-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-orange-700">Filter</button>
                    </form>
                </div>
            </div>

            <div class="mb-6 flex flex-wrap gap-3">
                <a href="{{ route('admin.reports.pdf', ['date' => $date]) }}" class="rounded-xl bg-orange-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-orange-700">Download PDF</a>
                <a href="{{ route('admin.reports.excel', ['date' => $date]) }}" class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-700">Download Excel</a>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
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
                            @foreach($rows as $row)
                                <tr class="text-sm text-slate-700">
                                    <td class="px-4 py-3 font-bold text-slate-950">{{ $row['nama'] }}</td>
                                    <td class="px-4 py-3">{{ $row['status_kehadiran_hari'] }}</td>
                                    <td class="px-4 py-3">{{ $row['hadir'] }}</td>
                                    <td class="px-4 py-3">{{ $row['izin'] }}</td>
                                    <td class="px-4 py-3">{{ $row['pulang'] }}</td>
                                    <td class="px-4 py-3">{{ $row['alfa'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
