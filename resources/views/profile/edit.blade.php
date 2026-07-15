<x-app-layout>
    <div class="min-h-screen bg-[#fff7ed]">
        <div class="mx-auto max-w-4xl px-6 py-10">
            <div class="mb-6 rounded-[2rem] bg-gradient-to-r from-orange-600 to-amber-400 p-8 text-white shadow-xl shadow-orange-200">
                <p class="text-sm font-black uppercase tracking-[0.2em] text-orange-100">Profile</p>
                <h1 class="mt-2 text-4xl font-black">Foto Profil & Password</h1>
                <p class="mt-2 text-orange-50">Peserta bisa mengubah foto profil dan password akunnya sendiri.</p>
            </div>

            @if (session('status') === 'password-updated')
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 font-semibold text-emerald-700">
                    Password berhasil diperbarui.
                </div>
            @endif

            @if (session('status') === 'photo-updated')
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 font-semibold text-emerald-700">
                    Foto profil berhasil diperbarui.
                </div>
            @endif

            @if (session('status') === 'photo-deleted')
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 font-semibold text-emerald-700">
                    Foto profil berhasil dihapus.
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[320px_1fr]">
                <div class="rounded-[2rem] border border-white/80 bg-white/85 p-7 shadow-xl shadow-orange-100 backdrop-blur">
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-orange-500">Foto Profil</p>

                    <div class="mt-5 flex flex-col items-center rounded-[1.5rem] bg-orange-50/80 p-6 text-center">
                        <div class="flex h-28 w-28 items-center justify-center overflow-hidden rounded-[2rem] bg-orange-100 text-3xl font-black uppercase text-orange-700 shadow-inner">
                            @if($user->photo_url)
                                <img src="{{ $user->photo_url }}" alt="Foto profil {{ $user->name }}" class="h-full w-full object-cover">
                            @else
                                {{ $user->initials() }}
                            @endif
                        </div>
                        <h2 class="mt-4 text-xl font-black text-zinc-950">{{ $user->name }}</h2>
                        <p class="text-sm font-semibold text-zinc-500">{{ $user->structureLabel() }}</p>
                    </div>

                    <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="photo" value="Upload Foto" />
                            <input id="photo" name="photo" type="file" accept="image/png,image/jpeg,image/jpg,image/webp" class="mt-2 block w-full rounded-2xl border border-orange-100 bg-white px-4 py-3 text-sm font-semibold text-zinc-700 file:mr-3 file:rounded-xl file:border-0 file:bg-orange-100 file:px-3 file:py-2 file:font-black file:text-orange-700">
                            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                            <p class="mt-2 text-xs font-semibold text-zinc-500">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
                        </div>

                        <button class="w-full rounded-2xl bg-gradient-to-r from-orange-600 to-amber-500 px-6 py-3 font-black text-white shadow-lg shadow-orange-200 transition hover:-translate-y-0.5">
                            Simpan Foto
                        </button>
                    </form>

                    @if($user->photo_url)
                        <form method="POST" action="{{ route('profile.photo.delete') }}" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button class="w-full rounded-2xl bg-orange-50 px-6 py-3 font-black text-orange-700 transition hover:bg-orange-100">
                                Hapus Foto
                            </button>
                        </form>
                    @endif
                </div>

                <div class="rounded-[2rem] border border-white/80 bg-white/85 p-8 shadow-xl shadow-orange-100 backdrop-blur">
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-orange-500">Keamanan Akun</p>
                    <h2 class="mt-1 text-2xl font-black text-zinc-950">Ganti Password</h2>

                    <form method="POST" action="{{ route('profile.password.update') }}" class="mt-6 space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="current_password" value="Password Lama" />
                            <x-text-input id="current_password" name="current_password" type="password" class="mt-2 block w-full rounded-2xl border-orange-100 px-4 py-3 focus:border-orange-500 focus:ring-orange-500" autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" value="Password Baru" />
                            <x-text-input id="password" name="password" type="password" class="mt-2 block w-full rounded-2xl border-orange-100 px-4 py-3 focus:border-orange-500 focus:ring-orange-500" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" value="Konfirmasi Password Baru" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-2 block w-full rounded-2xl border-orange-100 px-4 py-3 focus:border-orange-500 focus:ring-orange-500" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <button class="rounded-2xl bg-zinc-950 px-6 py-3 font-black text-white shadow-lg shadow-zinc-200 transition hover:-translate-y-0.5 hover:bg-orange-700">
                            Simpan Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
