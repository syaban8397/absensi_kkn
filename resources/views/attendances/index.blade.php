<x-app-layout>
    <div class="min-h-screen bg-[#fff7ed]">
        <div class="mx-auto max-w-4xl px-6 py-12">
            <div class="rounded-[2rem] border border-white/80 bg-white/85 p-8 text-center shadow-xl shadow-orange-100 backdrop-blur">
                <p class="text-sm font-black uppercase tracking-[0.2em] text-orange-500">Absensi KKN</p>
                <h1 class="mt-2 text-3xl font-black text-zinc-950">Pilih Halaman Absensi</h1>
                <p class="mt-2 text-zinc-500">Gunakan sidebar garis tiga di appbar atau tombol berikut.</p>
                <div class="mt-6 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('attendances.morning') }}" class="rounded-2xl bg-orange-600 px-5 py-3 font-black text-white">Absen Pagi</a>
                    <a href="{{ route('attendances.evening') }}" class="rounded-2xl bg-amber-500 px-5 py-3 font-black text-white">Absen Sore</a>
                    <a href="{{ route('attendances.history') }}" class="rounded-2xl bg-zinc-950 px-5 py-3 font-black text-white">Data Absensi</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
