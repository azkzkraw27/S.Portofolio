<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function navbar()
    {
        return view('admin.settings.navbar');
    }

    public function footer()
    {
        return view('admin.settings.footer');
    }

    public function welcome()
    {
        return view('admin.settings.welcome');
    }

    // Form tampilan background/GIF Auth (Login & Register)
    public function authAppearance()
    {
        return view('admin.settings.auth_appearance');
    }

    // Update GIF / Background Auth (Diselaraskan ke Key-Value Store)
    public function updateAuthAppearance(Request $request)
    {
        $request->validate([
            'auth_bg' => 'required|image|mimes:gif,jpg,jpeg,png,webp|max:10240', // Maksimal 10MB
        ]);

        if ($request->hasFile('auth_bg')) {
            // Hapus file lama dari storage jika ada
            $oldBg = Setting::get('auth_bg');
            if ($oldBg && Storage::disk('public')->exists($oldBg)) {
                Storage::disk('public')->delete($oldBg);
            }

            // Simpan file GIF baru ke folder public/storage/settings
            $path = $request->file('auth_bg')->store('settings', 'public');

            // Simpan ke database dengan Key "auth_bg"
            Setting::updateOrCreate(
                ['key' => 'auth_bg'],
                ['value' => $path]
            );
        }

        return redirect()->back()->with('success', 'Gambar GIF / Background Auth berhasil diperbarui!');
    }

    // Process Update Web, SEO, Navbar, Footer, & Welcome Settings
    public function update(Request $request)
    {
        $request->validate([
            // General Web & SEO
            'site_name'        => 'nullable|string|max:255',
            'site_title'       => 'nullable|string|max:255',
            'site_version'     => 'nullable|string|max:50',
            'auth_subtitle'    => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
            'site_logo'        => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'site_favicon'     => 'nullable|image|mimes:ico,png,jpg,svg,webp|max:1024',
            'hero_image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'about_image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',

            // Navbar
            'navbar_menus'     => 'nullable|array',
            'navbar_cta_text'  => 'nullable|string|max:255',
            'navbar_cta_url'   => 'nullable|string|max:255',
        ]);

        // A. Simpan Dynamic Navbar Items (JSON)
        if ($request->has('navbar_menus')) {
            $menus = array_values($request->input('navbar_menus'));
            Setting::updateOrCreate(['key' => 'navbar_menus'], ['value' => json_encode($menus)]);
        }

        // B. Toggle Status Section Enable / Disable (0 atau 1)
        if ($request->isMethod('post') && $request->routeIs('settings.update')) {
            $toggleKeys = [
                'enable_hero',
                'enable_trusted',
                'enable_services',
                'enable_about',
                'enable_projects',
                'enable_pricing',
                'enable_blog',
                'enable_faq',
                'enable_testimonial',
            ];

            // Jika form welcome disubmit, update status sakelar
            if ($request->has('section_form_flag')) {
                foreach ($toggleKeys as $key) {
                    Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $request->has($key) ? '1' : '0']
                    );
                }
            }
        }

        // C. List Field Teks / String Biasa
        $fields = [
            'site_name', 'site_title', 'site_version', 'auth_subtitle',
            'meta_description', 'meta_keywords',
            'navbar_cta_text', 'navbar_cta_url',

            // Welcome - Hero
            'hero_badge', 'hero_title', 'hero_subtitle',
            'hero_btn1_text', 'hero_btn1_url', 'hero_btn2_text', 'hero_btn2_url',
            'hero_trust_text', 'hero_card_title', 'hero_card_subtitle',

            // Welcome - Trusted
            'trusted_title', 'trusted_brands',

            // Welcome - Services
            'services_badge', 'services_title',
            'service1_title', 'service1_desc',
            'service2_title', 'service2_desc',
            'service3_title', 'service3_desc',

            // Welcome - About
            'about_badge', 'about_title', 'about_desc',
            'about_feat1', 'about_feat2', 'about_feat3', 'about_feat4',

            // Welcome - Pricing
            'pricing_badge', 'pricing_title', 'pricing_desc',
            'pricing_feat1', 'pricing_feat2', 'pricing_feat3',
            'pricing_price_tag', 'pricing_amount', 'pricing_btn_text', 'pricing_btn_url', 'pricing_guarantee',

            // Footer
            'footer_description', 'footer_copyright',
            'footer_link1_text', 'footer_link1_url', 'footer_link2_text', 'footer_link2_url',
            'footer_link3_text', 'footer_link3_url', 'footer_link4_text', 'footer_link4_url',
            'footer_facebook', 'footer_instagram', 'footer_twitter'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::updateOrCreate(
                    ['key' => $field],
                    ['value' => $request->input($field)]
                );
            }
        }

        // D. Upload Gambar & File Media
        if ($request->hasFile('site_logo')) {
            if ($old = Setting::get('site_logo')) Storage::disk('public')->delete($old);
            Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $request->file('site_logo')->store('settings', 'public')]);
        }

        if ($request->hasFile('site_favicon')) {
            if ($old = Setting::get('site_favicon')) Storage::disk('public')->delete($old);
            Setting::updateOrCreate(['key' => 'site_favicon'], ['value' => $request->file('site_favicon')->store('settings', 'public')]);
        }

        if ($request->hasFile('hero_image')) {
            if ($old = Setting::get('hero_image')) Storage::disk('public')->delete($old);
            Setting::updateOrCreate(['key' => 'hero_image'], ['value' => $request->file('hero_image')->store('settings', 'public')]);
        }

        if ($request->hasFile('about_image')) {
            if ($old = Setting::get('about_image')) Storage::disk('public')->delete($old);
            Setting::updateOrCreate(['key' => 'about_image'], ['value' => $request->file('about_image')->store('settings', 'public')]);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
