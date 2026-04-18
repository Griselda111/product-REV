<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Profil Saya | Admin</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/BPTTG_DIY-removebg-preview.png') }}">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" />
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>
<body class="g-sidenav-show bg-gray-100">

@include('sidebar.admin')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

  @include('admin.topnavbar.topnav', ['title' => 'Profil Saya'])

  <div class="container-fluid py-4">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <div class="mb-3">
              <h5 class="mb-1">Edit Profil</h5>
              <small class="text-muted">Perbarui nama tampilan Anda.</small>
            </div>

            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <form action="{{ route('admin.profile.update') }}" method="POST">
              @csrf
              @method('PUT')
              <div class="d-flex justify-content-center mb-4">
                <div class="profile-avatar d-inline-flex align-items-center justify-content-center">
                  <img src="{{ asset('assets/img/img_avatar.png') }}" alt="Avatar" class="w-100 h-100 rounded-circle">
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Nama</label>
                <input type="text" name="name" class="form-control bg-light border" value="{{ old('name', $user->name) }}" placeholder="Nama lengkap" required>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" class="form-control bg-light border" value="{{ $user->email }}" readonly>
                <div class="form-text">Email tidak dapat diubah.</div>
              </div>
              <div class="pt-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="footer py-3 text-center text-muted">
    <div class="container-fluid text-center text-sm text-muted">
        © {{ date('Y') }} Balai Pengembangan Teknologi Tepat Guna (BPTTG) DIY
    </div>
  </footer>

</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>

<style>
  body { background: #f5f5f5; }
  .card { border-radius: 16px; }
  .profile-link {
    border: 1px solid #e5e7eb;
    border-radius: 999px;
    transition: background 0.2s, box-shadow 0.2s;
  }
  .profile-link:hover {
    background: #f7f7f9;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
  }
  .profile-avatar {
    width: 84px;
    height: 84px;
    border-radius: 50%;
    background: #eef2ff;
    font-size: 44px;
  }
</style>

</body>
</html>
