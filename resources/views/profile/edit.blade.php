@extends(auth()->check() && auth()->user()->role === 'admin' ? 'layouts.app' : 'layouts.user')

@section('content')
<div class="space-y-6 pb-12" x-data="{ tab: 'profile' }">

    <!-- Breadcrumb Header -->
    <div class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
        Dashboard / {{ auth()->user()->role === 'admin' ? 'Platform Administration' : 'Client Area' }} / Users / <span class="text-blue-600 dark:text-blue-400 font-bold">{{ strtoupper(Auth::user()->name) }}</span>
    </div>

    <!-- TAB NAVIGATION BAR -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700/80 p-2 shadow-sm flex items-center gap-2 overflow-x-auto transition-colors duration-300">

        <button @click="tab = 'profile'" :class="tab === 'profile' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60'" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer whitespace-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            User profile
        </button>

        <button @click="tab = 'avatar'" :class="tab === 'avatar' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60'" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer whitespace-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            Avatar
        </button>

        <button @click="tab = 'password'" :class="tab === 'password' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60'" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer whitespace-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            Change password
        </button>

        <button @click="tab = 'preferences'" :class="tab === 'preferences' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60'" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer whitespace-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /></svg>
            Preferences
        </button>

    </div>

    <!-- ISI KONTEN TIAP TAB -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700/80 p-8 shadow-sm transition-colors duration-300">

        <!-- KONTEN TAB 1: USER PROFILE -->
        <div x-show="tab === 'profile'" class="space-y-6">
            @if (session('status') === 'profile-updated')
                <div class="p-4 mb-4 text-xs font-bold text-emerald-700 bg-emerald-100 dark:bg-emerald-900/40 dark:text-emerald-300 rounded-xl">
                    ✓ Profil berhasil diperbarui!
                </div>
            @endif

            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')

                <!-- Input tersembunyi untuk kolom name wajib bawaan Laravel Breeze -->
                <input type="hidden" name="name" value="{{ old('name', $user->name) }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
                    </div>

                    <!-- Last Name -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
                    </div>

                    <!-- Username -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">Username <span class="text-red-500">*</span></label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" required class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
                    </div>

                    <!-- Phone -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Nomor Telepon / WhatsApp" class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-lg shadow-blue-500/20 transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Update
                    </button>
                </div>
            </form>
        </div>

        <!-- KONTEN TAB 2: AVATAR -->
        <div x-show="tab === 'avatar'" class="space-y-6" style="display: none;">
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Foto Profil / Avatar</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Unggah foto avatar terbaik Anda (Format: JPG, PNG, WEBP. Maks: 2MB).</p>
            </div>

            @if (session('status') === 'avatar-updated')
                <div class="p-4 mb-4 text-xs font-bold text-emerald-700 bg-emerald-100 dark:bg-emerald-900/40 dark:text-emerald-300 rounded-xl">
                    ✓ Avatar berhasil diperbarui!
                </div>
            @endif

            <form method="post" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('patch')

                <div class="flex items-center gap-6 py-4">
                    <!-- Preview Avatar / Inisial -->
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-2 border-blue-500 shadow-md shrink-0">
                    @else
                        <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center text-2xl font-black shadow-inner shrink-0">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif

                    <div class="space-y-3 w-full">
                        <input type="file" name="avatar" accept="image/*" required class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                        @error('avatar')
                            <p class="text-xs text-red-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-lg shadow-blue-500/20 transition cursor-pointer">
                        Simpan Avatar
                    </button>
                </div>
            </form>
        </div>

        <!-- KONTEN TAB 3: CHANGE PASSWORD -->
        <div x-show="tab === 'password'" class="space-y-6" style="display: none;">
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Ubah Kata Sandi</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>
            </div>

            @if (session('status') === 'password-updated')
                <div class="p-4 mb-4 text-xs font-bold text-emerald-700 bg-emerald-100 dark:bg-emerald-900/40 dark:text-emerald-300 rounded-xl">
                    ✓ Kata sandi berhasil diperbarui!
                </div>
            @endif

            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('put')

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">Current Password</label>
                    <input type="password" name="current_password" autocomplete="current-password" class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
                    @if($errors->updatePassword->has('current_password'))
                        <p class="text-xs text-red-500 font-bold">{{ $errors->updatePassword->first('current_password') }}</p>
                    @endif
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">New Password</label>
                    <input type="password" name="password" autocomplete="new-password" class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
                    @if($errors->updatePassword->has('password'))
                        <p class="text-xs text-red-500 font-bold">{{ $errors->updatePassword->first('password') }}</p>
                    @endif
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide">Confirm Password</label>
                    <input type="password" name="password_confirmation" autocomplete="new-password" class="w-full bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-600 transition">
                    @if($errors->updatePassword->has('password_confirmation'))
                        <p class="text-xs text-red-500 font-bold">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                    @endif
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-lg shadow-blue-500/20 transition cursor-pointer">
                        Save Password
                    </button>
                </div>
            </form>
        </div>

        <!-- KONTEN TAB 4: PREFERENCES -->
        <div x-show="tab === 'preferences'" class="space-y-6" style="display: none;">
            <h3 class="text-base font-bold text-slate-900 dark:text-white">Preferences Sistem</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400">Kelola pengaturan preferensi tampilan dan mode warna di sini.</p>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700">
                    <div>
                        <p class="text-xs font-bold text-slate-800 dark:text-white">Mode Tampilan Gelap / Terang</p>
                        <p class="text-[11px] text-slate-400">Sesuaikan tema sesuai kenyamanan Anda.</p>
                    </div>
                    <button type="button" onclick="toggleAdminDarkMode()" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition cursor-pointer">
                        Ganti Tema
                    </button>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
