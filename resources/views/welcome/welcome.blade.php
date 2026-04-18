<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPTTG DIY</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/img/BPTTG_DIY-removebg-preview.png') }}">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Iconify -->
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white min-h-screen flex flex-col">

    <!-- Navigation -->
    <nav class="w-full bg-slate-100 border-b border-slate-200">
        <div class="max-w-[1400px] mx-auto flex items-center justify-between px-6 py-3 md:px-12 lg:px-20">

            <div class="flex items-center">
                <img src="/assets/img/BPTTG_DIY-removebg-preview.png" alt="Logo" class="w-15 h-14 mr-2">
                <img src="/assets/img/BPTTG DIY word.png" alt="Logo" class="w-15 h-7 mr-2">
            </div>

            <div class="hidden md:flex items-center gap-7">
                <div class="flex items-center gap-5">
                    <a href="#" class="text-[15px] font-medium text-slate-700 hover:text-slate-900 transition">Home</a>
                    <a href="#about" class="text-[15px] font-medium text-slate-700 hover:text-slate-900 transition">About Us</a>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}"
                       class="bg-slate-700 hover:bg-slate-800 text-white font-medium px-6 py-2.5 rounded-full transition-colors text-[15px]">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                       class="bg-slate-900 hover:bg-black text-white font-medium px-6 py-2.5 rounded-full transition-colors text-[15px]">
                        Sign Up
                    </a>
                </div>
            </div>

            <button class="md:hidden text-slate-700">
                <iconify-icon icon="lucide:menu" width="24"></iconify-icon>
            </button>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="flex-1 w-full">

        <!-- Hero -->
        <section class="flex flex-col justify-center max-w-[1400px] mx-auto px-6 md:px-12 lg:px-20 pb-24">
            <div class="max-w-3xl space-y-8 mt-10 md:mt-0">

                <div class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-full bg-emerald-50 w-fit mt-3">
                    <span class="h-2 w-2 rounded-full bg-emerald-600"></span>
                    <span class="text-xs font-semibold text-emerald-700 uppercase tracking-wide">
                        Pemerintah Daerah DIY
                    </span>
                </div>

                <h1 class="text-5xl md:text-6xl lg:text-[45px] font-bold text-slate-900 tracking-tight leading-[1.15]">
                    Balai Pengembangan <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">
                        (BPTTG) Dinas Perindustrian dan Perdagangan D. I. Yogyakarta
                    </span>
                </h1>

                <p class="text-slate-600 text-lg md:text-[19px] leading-relaxed font-light max-w-xl">
                    Mendorong inovasi dan penerapan teknologi tepat guna untuk meningkatkan
                    produktivitas, efisiensi, dan kemandirian masyarakat serta UMKM
                    di Daerah Istimewa Yogyakarta.
                </p>

                <a href="#about"
                   class="bg-emerald-700 hover:bg-emerald-800 text-white font-medium
                          px-8 py-3.5 rounded-full transition-all text-[15px]
                          flex items-center gap-2 w-fit group">
                    Tentang Kami
                    <iconify-icon icon="lucide:arrow-right"
                        width="18"
                        class="text-emerald-200 group-hover:translate-x-0.5 transition-transform">
                    </iconify-icon>
                </a>
            </div>
        </section>

        <!-- About / Profile / Vision Mission -->
        <section id="about" class="bg-slate-50 py-16">
            <div class="max-w-[1100px] mx-auto px-6 md:px-12 lg:px-20 space-y-12">

                <!-- Profile -->
                <div class="max-w-3xl">
                    <h2 class="text-3xl font-bold text-slate-900 mb-5">Profil</h2>
                    <p class="text-slate-600 leading-relaxed text-[17px]">
                        Balai Pengembangan Teknologi Tepat Guna merupakan salah satu Unit Pelaksana Teknis (UPT)
                        di bawah Dinas Perindustrian dan Perdagangan Daerah Istimewa Yogyakarta yang beralamat
                        di Jalan Kusumanegara No. 168, Muja Muju, Umbulharjo, Kota Yogyakarta.
                        Menurut Pergub No. 74 Tahun 2023 Pasal 4 ayat (1), Balai Pengembangan Teknologi Tepat Guna
                        mempunyai tugas melaksanakan pengembangan dan penerapan Teknologi Tepat Guna untuk
                        meningkatkan efisiensi, produktivitas, nilai tambah dan daya saing.
                    </p>
                </div>

                <!-- Vision & Mission -->
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h2 class="text-3xl font-bold text-slate-900 mb-4">Visi</h2>
                        <p class="text-slate-600 leading-relaxed">
                            Mewujudkan Alat Tepat Guna (ATG) sebagai sarana peningkatan kualitas
                            dan kapasitas produksi IKM untuk peningkatan daya saing menuju
                            kemandirian dan kesejahteraan masyarakat IKM.
                        </p>
                    </div>

                    <div>
                        <h2 class="text-3xl font-bold text-slate-900 mb-4">Misi</h2>
                        <p class="text-slate-600 leading-relaxed">
                            Meningkatkan kinerja dan kompetensi aparat menuju pelayanan prima
                            dengan manajemen yang efisien.
                        </p>
                    </div>
                </div>

            </div>
        </section>

    </main>
    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 text-center py-5 text-sm">
        © 2026 Balai Pengembangan Teknologi Tepat Guna (BPTTG) DIY
    </footer>
</body>
</html>