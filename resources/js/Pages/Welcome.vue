<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
</script>

<template>
    <Head title="Home | MyPortfolio" />

    <PublicLayout>
        <!-- Hero Section -->
        <section class="relative overflow-hidden pt-16 md:pt-24 pb-32">
            <!-- Background Ornaments (Aksen Biru seperti di referensi) -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-100 dark:bg-brand-primary/20 blur-3xl opacity-50"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-brand-accent/20 blur-3xl opacity-50"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

                    <!-- Kiri: Teks -->
                    <div>
                        <p class="text-brand-accent font-semibold tracking-wide uppercase mb-3">Welcome to my creative space</p>
                        <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6 text-slate-900 dark:text-white">
                            Membangun <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-brand-accent">Karya Digital</span> yang Luar Biasa.
                        </h1>
                        <p class="text-lg text-slate-600 dark:text-slate-300 mb-8 max-w-lg">
                            Saya membantu bisnis dan individu menciptakan website berkinerja tinggi, modern, dan mudah dikelola untuk mencapai target pasar Anda.
                        </p>

                        <div class="flex space-x-4">
                            <a href="#projects" class="bg-brand-primary hover:bg-blue-800 text-white px-8 py-3 rounded-full font-medium transition shadow-lg shadow-blue-500/30">
                                Lihat Project
                            </a>
                            <a href="#pricelist" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 px-8 py-3 rounded-full font-medium transition">
                                Pricelist
                            </a>
                        </div>
                    </div>

                    <!-- Kanan: Gambar/Ilustrasi -->
                    <div class="relative">
                        <!-- Placeholder gambar disesuaikan dengan tema -->
                        <div class="aspect-[4/3] rounded-3xl bg-gradient-to-tr from-slate-200 to-slate-100 dark:from-slate-800 dark:to-slate-700 flex items-center justify-center shadow-2xl relative overflow-hidden border-4 border-white dark:border-slate-800">
                            <span class="text-slate-400 dark:text-slate-500 text-xl font-medium">Foto / 3D Illustration</span>

                            <!-- Floating Card ala referensi desain -->
                            <div class="absolute bottom-6 left-[-20px] md:-left-8 bg-white dark:bg-slate-800 p-4 rounded-xl shadow-xl border border-slate-100 dark:border-slate-700 flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Proyek Selesai</p>
                                    <p class="text-sm font-bold text-slate-900 dark:text-white">100+ Klien</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Placeholder Section (Nanti kita isi data dinamis) -->
        <section id="projects" class="py-20 bg-slate-50 dark:bg-slate-900/50">
             <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                 <h2 class="text-3xl font-bold mb-4">Portfolio Project</h2>
                 <p class="text-slate-500">Kumpulan karya terbaik akan muncul di sini.</p>
             </div>
        </section>

    </PublicLayout>
</template>
