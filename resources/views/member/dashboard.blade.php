<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Dashboard | Member</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/BPTTG_DIY-removebg-preview.png') }}">

  <!-- Fonts -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />

  <!-- Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

  <!-- Material Icons -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" />

  <!-- CSS -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">

  <!-- Sidebar -->
  @include('sidebar.sidebar')
  <!-- End Sidebar -->

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

    <!-- Navbar -->
    @include('member.topnavbar.topnav', ['title' => 'Dashboard'])
    <!-- End Navbar -->

    <!-- CONTENT -->
    <div class="container-fluid py-4">
      <div class="row mb-3">
        <div class="col-12">
          <h4 class="mb-1">DASHBOARD MEMBER</h4>
          <div class="text-muted">Status Proses Produksi</div>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-md-4">
          <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center">
              <div class="fw-bold text-uppercase mb-2" style="letter-spacing:0.5px;">Belum Diproses</div>
              <div class="display-5 fw-bold">{{ $belum ?? 0 }}</div>
            </div>
            <a href="{{ route('orders.index', ['status_produksi' => 1]) }}" class="btn w-100 text-white" style="background:#c8102e;border-top-left-radius:0;border-top-right-radius:0;">
              Lihat Detail <span class="float-end">&rsaquo;</span>
            </a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center">
              <div class="fw-bold text-uppercase mb-2" style="letter-spacing:0.5px;">Sedang Diproses</div>
              <div class="display-5 fw-bold">{{ $proses ?? 0 }}</div>
            </div>
            <a href="{{ route('orders.index', ['status_produksi' => 2]) }}" class="btn w-100 text-white" style="background:#d39400;border-top-left-radius:0;border-top-right-radius:0;">
              Lihat Detail <span class="float-end">&rsaquo;</span>
            </a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center">
              <div class="fw-bold text-uppercase mb-2" style="letter-spacing:0.5px;">Selesai Diproses</div>
              <div class="display-5 fw-bold">{{ $selesai ?? 0 }}</div>
            </div>
            <a href="{{ route('orders.index', ['status_produksi' => 3]) }}" class="btn w-100 text-white" style="background:#0a9a58;border-top-left-radius:0;border-top-right-radius:0;">
              Lihat Detail <span class="float-end">&rsaquo;</span>
            </a>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-lg-8">
          <div class="card shadow-sm border-0">
            <div class="card-body">
              <h6 class="fw-bold mb-3">FAQ (Frequently Asked Questions)</h6>
              <ul class="mb-0">
                <li>Data <strong>Customer</strong> dan <strong>Biaya Jasa</strong> di area member hanya bisa dibaca. Jika perlu penambahan/perubahan, hubungi admin untuk menambahkan dari panel admin.</li>
                <li><strong>Status Pembayaran</strong> isi sesuai kondisi saat order dibuat (Belum Lunas / DP / Lunas).</li>
                <li><strong>DP</strong>: isi kolom DP, sistem otomatis hitung sisa = total - DP.</li>
                <li><strong>Lunas</strong>: pilih Lunas, DP otomatis sama dengan total dan sisa jadi 0.</li>
                <li><strong>Kode Order</strong> dibuat otomatis; tidak perlu diisi manual.</li>
                <li>Pilih <strong>Nama Customer</strong>; kolom ID terisi sendiri.</li>
                <li><strong>Tarif</strong> mengikuti jasa yang dipilih; ubah jasa bila tarif tidak sesuai.</li>
                <li>Butuh menambah jasa baru atau customer baru tapi tidak punya akses? Laporkan ke admin agar ditambahkan dari halaman admin.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <style>
        body { background: #ede2ff !important; }
        .card { border-radius: 10px; }
      </style>
    </div>

    <!-- Footer -->
    <footer class="footer py-3">
      <div class="container-fluid text-center text-sm text-muted">
        © {{ date('Y') }} Balai Pengembangan Teknologi Tepat Guna (BPTTG) DIY
      </div>
    </footer>

  </main>

  <!-- Core JS -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>

  <!-- Material Dashboard -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>

  <!-- 🌙 SIMPAN DARK MODE -->
  <script>
    const darkToggle = document.getElementById('dark-version');

    if (localStorage.getItem('dark-mode') === 'enabled') {
      darkToggle.checked = true;
      darkMode(darkToggle);
    }

    darkToggle.addEventListener('click', function () {
      localStorage.setItem(
        'dark-mode',
        this.checked ? 'enabled' : 'disabled'
      );
    });
  </script>

</body>
</html>
