<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const isDarkMode = ref(false);

// Fungsi untuk toggle dark mode
const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    if (isDarkMode.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
};

// Cek preferensi tema saat halaman dimuat
onMounted(() => {
    if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        isDarkMode.value = true;
        document.documentElement.classList.add('dark');
    }
});
</script>

<template>
    <!-- Wrapper utama dengan transisi warna halus -->
    <div class="min-h-screen bg-brand-light dark:bg-brand-dark text-slate-800 dark:text-slate-200 transition-colors duration-300">

        <!-- Navbar -->
        <nav class="fixed w-full z-50 top-0 backdrop-blur-md bg-white/70 dark:bg-brand-dark/80 border-b border-slate-200 dark:border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <Link href="/" class="text-2xl font-bold text-brand-primary dark:text-brand-accent">
                            MyPortfolio<span class="text-slate-800 dark:text-white">.</span>
                        </Link>
                    </div>

                    <!-- Menu Navigasi Tengah -->
                    <div class="hidden md:flex space-x-8 font-medium">
                        <Link href="/" class="hover:text-brand-primary transition">Home</Link>
                        <Link href="#projects" class="hover:text-brand-primary transition">Projects</Link>
                        <Link href="#pricelist" class="hover:text-brand-primary transition">Pricelist</Link>
                        <Link href="#blog" class="hover:text-brand-primary transition">Blog</Link>
                    </div>

                    <!-- Tombol Kanan (Dark Mode & Login) -->
                    <div class="flex items-center space-x-4">
                        <button @click="toggleDarkMode" class="p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-700 transition">
                            <!-- Icon Sun/Moon (pakai SVG sederhana) -->
                            <svg v-if="!isDarkMode" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                        </button>

                        <Link :href="route('login')" class="bg-brand-primary hover:bg-blue-800 text-white px-5 py-2 rounded-full font-medium transition shadow-lg shadow-blue-500/30">
                            Client Login
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content (Slot) -->
        <main class="pt-20">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 py-10 mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-slate-500 dark:text-slate-400">
                &copy; {{ new Date().getFullYear() }} MyPortfolio. All rights reserved.
            </div>
        </footer>
    </div>
</template>
