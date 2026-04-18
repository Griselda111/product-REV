<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Dashboard | BPTTG DIY</title>
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

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl"
      id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0">
            <li class="breadcrumb-item text-sm">
              <a class="opacity-5 text-dark" href="#">Pages</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
              Dashboard
            </li>
          </ol>
        </nav>

        <ul class="navbar-nav ms-auto d-flex align-items-center">

          <!-- 🌙 DARK MODE TOGGLE -->
          <li class="nav-item px-3 d-flex align-items-center">
            <span class="me-2 text-sm text-secondary">Dark</span>
            <div class="form-check form-switch mb-0">
              <input class="form-check-input" type="checkbox"
                     id="dark-version"
                     onclick="darkMode(this)">
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->

    <!-- CONTENT -->
    <div class="container-fluid py-4">
      <!-- isi dashboard kamu di sini -->
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
