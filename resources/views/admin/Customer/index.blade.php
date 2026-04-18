<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Customer | Admin</title>
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

  @include('admin.topnavbar.topnav', ['title' => 'Customer'])

  <div class="container-fluid py-4">
    <div class="card shadow mb-4">

      <div class="card-header py-3 d-flex justify-content-between align-items-center gap-3">
        <div>
          <h3 class="mb-2">Daftar Customer</h3>
          <button class="btn btn-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#modalCreateCustomer">
            <i class="material-symbols-rounded align-middle me-1">add</i>Tambah Customer
          </button>
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
                <td class="align-middle">
                  <div class="action-inline">
                    <button class="btn btn-bpttg-yellow btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEditCustomer{{ $customer->id_customer }}">
                      <i class="material-symbols-rounded align-middle me-1">edit</i>Edit
                    </button>
                    <button class="btn btn-danger text-white btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalDeleteCustomer{{ $customer->id_customer }}">
                      <i class="material-symbols-rounded align-middle me-1">delete</i>Hapus
                    </button>
                  </div>

                  <!-- Modal Edit -->
                  <div class="modal fade jasa-edit-modal" id="modalEditCustomer{{ $customer->id_customer }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header border-0 pb-0">
                          <h5 class="modal-title">Edit Customer</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.customers.update', $customer->id_customer) }}" method="POST" class="customer-phone-form" novalidate>
                          @csrf
                          @method('PUT')
                          <div class="modal-body">
                            <div class="mb-3 text-center">
                              <div class="fw-semibold text-muted small">ID Customer (auto)</div>
                              <div class="fs-6 fw-bold">{{ $customer->id_customer_display }}</div>
                            </div>
                            <div class="mb-3">
                              <label class="form-label fw-semibold text-center w-100" for="editNamaPemesan{{ $customer->id_customer }}">Nama Pemesan</label>
                              <input type="text"
                                     name="nama_pemesan"
                                     class="form-control"
                                     id="editNamaPemesan{{ $customer->id_customer }}"
                                     placeholder="Nama pemesan"
                                     value="{{ $customer->nama_pemesan }}"
                                     required>
                            </div>
                            <div class="row g-3">
                              <div class="col-md-6">
                                <label class="form-label fw-semibold text-center w-100" for="editNoTelp{{ $customer->id_customer }}">No. Telp</label>
                                <input type="text"
                                       name="no_telp"
                                       class="form-control"
                                       id="editNoTelp{{ $customer->id_customer }}"
                                       placeholder="08xxxxxxxxxx"
                                       inputmode="numeric"
                                       pattern="[0-9]*"
                                       maxlength="20"
                                       value="{{ $customer->no_telp }}">
                              </div>
                              <div class="col-md-6">
                                <label class="form-label fw-semibold text-center w-100" for="editAlamat{{ $customer->id_customer }}">Alamat</label>
                                <input type="text"
                                       name="alamat"
                                       class="form-control"
                                       id="editAlamat{{ $customer->id_customer }}"
                                       placeholder="Alamat lengkap"
                                       value="{{ $customer->alamat }}">
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-bpttg-yellow">Simpan</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!-- Modal Delete -->
                  <div class="modal fade" id="modalDeleteCustomer{{ $customer->id_customer }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Hapus Customer</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Yakin ingin menghapus <strong>{{ $customer->nama_pemesan }}</strong> ({{ $customer->id_customer_display }})?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                          <form action="{{ route('admin.customers.destroy', $customer->id_customer) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                </td>
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

<!-- Modal Create -->
<div class="modal fade jasa-edit-modal" id="modalCreateCustomer" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title">Tambah Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.customers.store') }}" method="POST" class="customer-phone-form" novalidate>
        @csrf
        <div class="modal-body">
          <div class="mb-3 text-center">
            <div class="fw-semibold text-muted small">ID Customer akan digenerate otomatis (customer-x)</div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold text-center w-100" for="createNamaPemesan">Nama Pemesan</label>
            <input type="text"
                   name="nama_pemesan"
                   class="form-control"
                   id="createNamaPemesan"
                   placeholder="Nama pemesan"
                   required>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold text-center w-100" for="createNoTelp">No. Telp</label>
              <input type="text"
                     name="no_telp"
                     class="form-control"
                     id="createNoTelp"
                     placeholder="08xxxxxxxxxx"
                     inputmode="numeric"
                     pattern="[0-9]*"
                     maxlength="20">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold text-center w-100" for="createAlamat">Alamat</label>
              <input type="text"
                     name="alamat"
                     class="form-control"
                     id="createAlamat"
                     placeholder="Alamat lengkap">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>

<script>
  if (window.jQuery) {
    $(document).ready(function(){
      $("#customerSearchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#customerTable tbody tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  }

  (function () {
    const digitsMessage = 'No. Telp harus diisi angka saja.';

    document.querySelectorAll('form.customer-phone-form').forEach((form) => {
      const phoneInput = form.querySelector('input[name="no_telp"]');

      if (!phoneInput) {
        return;
      }

      const syncValidityMessage = () => {
        phoneInput.setCustomValidity('');

        if (phoneInput.validity.patternMismatch) {
          phoneInput.setCustomValidity(digitsMessage);
        }
      };

      phoneInput.addEventListener('input', () => {
        phoneInput.setCustomValidity('');
      });

      phoneInput.addEventListener('invalid', () => {
        syncValidityMessage();
      });

      form.addEventListener('submit', (event) => {
        syncValidityMessage();

        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();

          if (typeof form.reportValidity === 'function') {
            form.reportValidity();
          }

          const firstInvalid = form.querySelector(':invalid');
          if (firstInvalid && typeof firstInvalid.focus === 'function') {
            firstInvalid.focus();
          }
        }
      });
    });
  })();
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
  .action-inline {
    display: inline-flex;
    gap: 0.4rem;
    flex-wrap: nowrap;
    white-space: nowrap;
  }
  .action-inline .btn {
    padding: 0.3rem 0.55rem;
    font-size: 12px;
    line-height: 1.2;
  }
  .btn-bpttg-yellow {
    background: #ffeb3b !important;
    border-color: #ffeb3b !important;
    color: #000 !important;
  }
  .btn-bpttg-yellow:hover,
  .btn-bpttg-yellow:focus {
    background: #ffe85a !important;
    border-color: #ffe85a !important;
    color: #000 !important;
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
