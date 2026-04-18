<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Customer | Member</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/BPTTG_DIY-removebg-preview.png') }}">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" />
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>
<body class="g-sidenav-show bg-gray-100">

@include('sidebar.sidebar')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

  @include('member.topnavbar.topnav', ['title' => 'Customer'])

  <div class="container-fluid py-4">
    <div class="card shadow mb-4">

      <div class="card-header py-3 d-flex justify-content-between align-items-center gap-3">
        <div>
          <h3 class="mb-0">Daftar Customer (Read Only)</h3>
        </div>

        <div class="input-group input-group-outline w-25">
          <span class="input-group-text bg-transparent">
            <i class="material-symbols-rounded text-secondary">search</i>
          </span>
          <input type="text" id="customerSearchInput" class="form-control" placeholder="Search anything...">
        </div>
      </div>

      <div class="card-body">

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

        <div class="table-responsive">
          <table class="table table-bordered" id="customerTable">
            <thead>
              <tr class="text-center" style="font-size:13px">
                <th>NO</th>
                <th>ID Customer</th>
                <th>Nama Pemesan</th>
                <th>No. Telp</th>
                <th>Alamat</th>
                <th>Tindakan</th>
              </tr>
            </thead>

            <tbody>
            @forelse ($customers as $customer)
              <tr class="text-center" style="font-size:13px">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $customer->id_customer_display }}</td>
                <td>{{ $customer->nama_pemesan }}</td>
                <td>{{ $customer->no_telp ?? '-' }}</td>
                <td>{{ $customer->alamat }}</td>
                <td class="align-middle text-muted">Read only</td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-4">Belum ada data customer.</td>
              </tr>
            @endforelse
            </tbody>
          </table>
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

<script>
  $(document).ready(function(){
    $("#customerSearchInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#customerTable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>

<style>
  .table { border-collapse: collapse !important; }
  .table td, .table th { border: 1px solid #0d0d0d !important; }
  .profile-link {
    border: 1px solid #e5e7eb;
    border-radius: 999px;
    transition: background 0.2s, box-shadow 0.2s;
  }
  .profile-link:hover {
    background: #f7f7f9;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
  }
  .jasa-edit-modal .modal-content { border-radius: 16px; }
  .jasa-edit-modal .modal-body { padding: 1.75rem 2rem 1.5rem; }
  .jasa-edit-modal .modal-header { padding: 1.25rem 2rem 0.5rem; }
  .jasa-edit-modal .modal-footer { padding: 0.75rem 2rem 1.5rem; }
  .jasa-edit-modal .form-label { margin-bottom: 0.4rem; }
  .jasa-edit-modal .form-text { margin-top: 0.4rem; }
  .jasa-edit-modal .form-control {
    background: #f7f8fa;
    border: 1px solid #e3e6ef;
    border-radius: 10px;
    box-shadow: none;
    padding: 0.7rem 0.9rem;
    line-height: 1.3;
  }
  .jasa-edit-modal .form-control::placeholder { color: #98a2b3; }
  .jasa-edit-modal .form-control[readonly],
  .jasa-edit-modal .form-control[disabled] { background: #f2f4f7; }
  .jasa-edit-modal .form-control:focus {
    border-color: #9aa7c7;
    box-shadow: 0 0 0 0.2rem rgba(154, 167, 199, 0.25);
  }
</style>

</body>
</html>
