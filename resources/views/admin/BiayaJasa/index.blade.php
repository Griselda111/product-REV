<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Biaya Jasa | Admin</title>
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

  @include('admin.topnavbar.topnav', ['title' => 'Biaya Jasa'])

  <div class="container-fluid py-4">
    <div class="card shadow mb-4">

      <div class="card-header py-3 d-flex justify-content-between align-items-center gap-3">
        <div>
          <h3 class="mb-2">Daftar Biaya Jasa</h3>
          <button class="btn btn-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#modalCreate">
            <i class="material-symbols-rounded align-middle me-1">add</i>Tambah Data
          </button>
        </div>

        <div class="input-group input-group-outline w-25">
          <span class="input-group-text bg-transparent">
            <i class="material-symbols-rounded text-secondary">search</i>
          </span>
          <input type="text" id="jasaSearchInput" class="form-control" placeholder="Search anything...">
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
          <table class="table table-bordered" id="jasaTable">
            <thead>
              <tr class="text-center" style="font-size:13px">
                <th>NO</th>
                <th>Nama Jasa</th>
                <th>Tarif</th>
                <th>Keterangan</th>
                <th>Tindakan</th>
              </tr>
            </thead>
            
            <tbody>
            @forelse ($jasas as $jasa)
              <tr class="text-center" style="font-size:13px">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $jasa->nama_jasa }}</td>
                <td>Rp {{ $jasa->tarif == (int)$jasa->tarif ? number_format($jasa->tarif, 0, ',', '') : number_format($jasa->tarif, 2, ',', '') }}</td>
                <td>{{ $jasa->keterangan ?? '-' }}</td>
                <td class="align-middle">
                  <div class="action-inline">
                    <button class="btn btn-bpttg-yellow btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEdit{{ $jasa->id }}">
                      <i class="material-symbols-rounded align-middle me-1">edit</i>Edit
                    </button>
                    <button class="btn btn-danger text-white btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalDelete{{ $jasa->id }}">
                      <i class="material-symbols-rounded align-middle me-1">delete</i>Hapus
                    </button>
                  </div>

                  <!-- Modal Edit -->
                  <div class="modal fade jasa-edit-modal" id="modalEdit{{ $jasa->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header border-0 pb-0">
                          <h5 class="modal-title">Edit Jasa</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.BiayaJasa.update', $jasa->id) }}" method="POST" class="jasa-tarif-form" novalidate>
                          @csrf
                          @method('PUT')
                          <div class="modal-body">
                            <div class="mb-3">
                              <label class="form-label fw-semibold text-center w-100" for="editNamaJasa{{ $jasa->id }}">Nama Jasa</label>
                              <input type="text"
                                     name="nama_jasa"
                                     class="form-control"
                                     id="editNamaJasa{{ $jasa->id }}"
                                     placeholder="Contoh: Level 1 Ringan"
                                     value="{{ $jasa->nama_jasa }}"
                                     required>
                              <div class="form-text text-center">Nama layanan yang akan tampil di tabel biaya jasa.</div>
                            </div>
                            <div class="row g-3">
                              <div class="col-md-6">
                                <label class="form-label fw-semibold text-center w-100" for="editTarif{{ $jasa->id }}">Tarif (Rp)</label>
                                <div class="jasa-suffix-wrap">
                                  <input type="text"
                                         name="tarif"
                                         class="form-control pe-5"
                                         id="editTarif{{ $jasa->id }}"
                                         placeholder="Contoh: 20000 atau 0,18"
                                         inputmode="decimal"
                                         maxlength="11"
                                         pattern="[0-9]{1,8}(?:,[0-9]{1,2})?"
                                         title="Gunakan angka tanpa titik pemisah ribuan dan maksimal 2 angka desimal. Contoh: 20000 atau 0,18"
                                         value="{{ $jasa->tarif == (int)$jasa->tarif ? number_format($jasa->tarif, 0, ',', '') : number_format($jasa->tarif, 2, ',', '') }}"
                                         required>
                                  <span class="jasa-suffix">Rp</span>
                                </div>
                                <div class="form-text text-center">Tanpa titik untuk ribuan. Koma untuk desimal (maks. 2 angka, contoh: 0,18)</div>
                              </div>
                              <div class="col-md-6">
                                <label class="form-label fw-semibold text-center w-100" for="editKeterangan{{ $jasa->id }}">Keterangan</label>
                                <input type="text"
                                       name="keterangan"
                                       class="form-control"
                                       id="editKeterangan{{ $jasa->id }}"
                                       aria-describedby="editKeteranganHelp{{ $jasa->id }}"
                                       value="{{ $jasa->keterangan }}">
                                <div class="form-text text-center" id="editKeteranganHelp{{ $jasa->id }}">
                                  Tambahkan info ukuran/satuan agar tidak membingungkan
                                </div>
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
                  <div class="modal fade" id="modalDelete{{ $jasa->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Hapus Jasa</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Yakin ingin menghapus <strong>{{ $jasa->nama_jasa }}</strong>?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                          <form action="{{ route('admin.BiayaJasa.destroy', $jasa->id) }}" method="POST">
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
                <td colspan="5" class="text-center py-4">Belum ada data jasa.</td>
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
<div class="modal fade jasa-edit-modal" id="modalCreate" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title">Tambah Jasa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.BiayaJasa.store') }}" method="POST" class="jasa-tarif-form" novalidate>
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold text-center w-100" for="createNamaJasa">Nama Jasa</label>
            <input type="text"
                   name="nama_jasa"
                   class="form-control"
                   id="createNamaJasa"
                   placeholder="Contoh: Level 1 Ringan"
                   required>
            <div class="form-text text-center">Nama layanan yang akan tampil di tabel biaya jasa.</div>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold text-center w-100" for="createTarif">Tarif (Rp)</label>
              <div class="jasa-suffix-wrap">
                <input type="text"
                       name="tarif"
                       class="form-control pe-5"
                       id="createTarif"
                       placeholder="Contoh: 20000 atau 0,18"
                       inputmode="decimal"
                       maxlength="11"
                       pattern="[0-9]{1,8}(?:,[0-9]{1,2})?"
                       title="Gunakan angka tanpa titik pemisah ribuan dan maksimal 2 angka desimal. Contoh: 20000 atau 0,18"
                       required>
                <span class="jasa-suffix">Rp</span>
              </div>
              <div class="form-text text-center">Tanpa titik untuk ribuan. Koma untuk desimal (maks. 2 angka, contoh: 0,18)</div>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold text-center w-100" for="createKeterangan">Keterangan</label>
              <input type="text"
                     name="keterangan"
                     class="form-control"
                     id="createKeterangan"
                     placeholder="Contoh: Ukuran A4 / Lembar">
              <div class="form-text text-center">Tambahkan info ukuran/satuan agar tidak membingungkan</div>
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
  $(document).ready(function(){
    $("#jasaSearchInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#jasaTable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

  (function () {
    const formatMessage = 'Sesuaikan dengan format yang diminta. Gunakan angka tanpa titik pemisah ribuan dan maksimal 2 angka desimal (contoh: 20000 atau 0,18).';
    const maxMessage = 'Tarif tidak boleh lebih dari 99999999,99.';

    document.querySelectorAll('form.jasa-tarif-form').forEach((form) => {
      const tarifInput = form.querySelector('input[name="tarif"]');

      if (!tarifInput) {
        return;
      }

      const syncValidityMessage = () => {
        tarifInput.setCustomValidity('');

        if (tarifInput.validity.valueMissing) {
          return;
        }

        const value = String(tarifInput.value ?? '').trim();
        const numericLike = /^[0-9]+(?:,[0-9]*)?$/.test(value);

        if (numericLike) {
          let integerPart = value.split(',', 2)[0] || '';
          integerPart = integerPart.replace(/^0+/, '');
          integerPart = integerPart === '' ? '0' : integerPart;

          // Kolom DB: decimal(10,2) => max 8 digit sebelum koma (contoh: 99999999,99)
          if (integerPart.length > 8) {
            tarifInput.setCustomValidity(maxMessage);
            return;
          }
        }

        if (tarifInput.validity.patternMismatch || tarifInput.validity.tooLong) {
          tarifInput.setCustomValidity(formatMessage);
        }
      };

      tarifInput.addEventListener('input', () => {
        tarifInput.setCustomValidity('');
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
  .modal.jasa-edit-modal {
    font-size: var(--bs-body-font-size);
    line-height: var(--bs-body-line-height);
  }
  #jasaTable .modal.jasa-edit-modal .form-text {
    max-width: 32rem;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
    line-height: 1.35;
    text-wrap: balance;
  }
  .jasa-edit-modal .modal-content {
    border-radius: 16px;
  }
  .jasa-edit-modal .modal-body {
    padding: 1.75rem 2rem 1.5rem;
  }
  .jasa-edit-modal .modal-header {
    padding: 1.25rem 2rem 0.5rem;
  }
  .jasa-edit-modal .modal-footer {
    padding: 0.75rem 2rem 1.5rem;
  }
  .jasa-edit-modal .form-label {
    margin-bottom: 0.4rem;
  }
  .jasa-edit-modal .form-text {
    margin-top: 0.4rem;
  }
  .jasa-edit-modal .form-control {
    background: #f7f8fa;
    border: 1px solid #e3e6ef;
    border-radius: 10px;
    box-shadow: none;
    padding: 0.7rem 0.9rem;
    line-height: 1.3;
  }
  .jasa-edit-modal .form-control::placeholder {
    color: #98a2b3;
  }
  .jasa-edit-modal .form-control[readonly],
  .jasa-edit-modal .form-control[disabled] {
    background: #f2f4f7;
  }
  .jasa-edit-modal .form-control:focus {
    border-color: #9aa7c7;
    box-shadow: 0 0 0 0.2rem rgba(154, 167, 199, 0.25);
  }
  .jasa-edit-modal .input-group {
    align-items: stretch;
  }
  .jasa-edit-modal .jasa-input-group {
    background: #f7f8fa;
    border: 1px solid #e3e6ef;
    border-radius: 10px;
    overflow: hidden;
  }
  .jasa-edit-modal .jasa-input-group .input-group-text {
    background: transparent;
    border: 0;
    padding: 0.6rem 0.85rem;
  }
  .jasa-edit-modal .jasa-input-group .form-control {
    background: transparent;
    border: 0;
    border-radius: 0;
  }
  .jasa-edit-modal .jasa-suffix-wrap {
    position: relative;
  }
  .jasa-edit-modal .jasa-suffix {
    position: absolute;
    right: 0.85rem;
    top: 50%;
    transform: translateY(-50%);
    color: #667085;
    font-size: 0.9rem;
    pointer-events: none;
  }
</style>

</body>
</html>
