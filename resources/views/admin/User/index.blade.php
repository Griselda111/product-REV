<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Dashboard | BPTTG DIY</title>
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

@include('admin.topnavbar.topnav', ['title' => 'User Management'])

<div class="container-fluid py-4">
  <div class="card shadow mb-4">

    <div class="card-header py-3 d-flex justify-content-between align-items-center">
      <h3 class="mb-0">Table User</h3>
      <div class="input-group input-group-outline w-25">
        <span class="input-group-text bg-transparent">
          <i class="material-symbols-rounded text-secondary">search</i>
        </span>
        <input type="text"
               id="userSearchInput"
               class="form-control"
               placeholder="Search anything...">
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable">
          <thead>
            <tr class="text-center" style="font-size:13px">
              <th>NO</th>
              <th>Username</th>
              <th>Role</th>
              <th>Tindakan</th>
            </tr>
          </thead>

          <tbody>
          @foreach ($user as $row)
            <tr class="text-center" style="font-size:13px">
              <td>{{ $loop->iteration }}</td>
              <td>{{ $row->name }}</td>
              <td>
                @if($row->role == 2)
                  <span class="badge bg-gradient-success">Admin</span>
                @else
                  <span class="badge bg-gradient-secondary">Member</span>
                @endif
              </td>

              <td class="align-middle">
                <div class="action-inline">

                  {{-- PROMOTE / DEMOTE --}}
                  @if(auth()->id() !== $row->id)
                    @if($row->role == 1)
                      {{-- Promote trigger --}}
                      <button class="btn btn-success text-white btn-sm"
                              data-bs-toggle="modal"
                              data-bs-target="#modalPromote{{ $row->id }}">
                        <i class="material-symbols-rounded align-middle me-1">arrow_upward</i>Promote
                      </button>
                    @else
                      {{-- Demote direct --}}
                      <form action="{{ route('admin.users.demote', $row->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-bpttg-yellow btn-sm">
                          <i class="material-symbols-rounded align-middle me-1">arrow_downward</i>Demote
                        </button>
                      </form>
                    @endif
                  @else
                    <button class="btn btn-outline-secondary btn-sm" disabled>
                      <i class="material-symbols-rounded align-middle me-1">person</i>Your Account
                    </button>
                  @endif

                  {{-- DELETE --}}
                  @if($row->role == 1 && auth()->id() !== $row->id)
                    <button class="btn btn-danger text-white btn-sm"
                      data-bs-toggle="modal"
                      data-bs-target="#confirmationModal{{ $row->id }}">
                      <i class="material-symbols-rounded align-middle me-1">delete</i>Delete
                    </button>
                  @endif
                </div>

                {{-- MODAL PROMOTE --}}
                @if($row->role == 1 && auth()->id() !== $row->id)
                <div class="modal fade modal-promote" id="modalPromote{{ $row->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title text-dark">Promote to Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <p class="mb-2">Anda akan mempromosikan <strong>{{ $row->name }}</strong> menjadi <strong>Admin</strong>.</p>
                        <p class="mb-0 text-muted">Admin memiliki akses penuh (CRUD) termasuk manajemen user. Pastikan user ini benar-benar dipercaya.</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('admin.users.promote', $row->id) }}" method="POST" class="d-inline">
                          @csrf
                          <button type="submit" class="btn btn-bpttg-yellow">Ya, Promote</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                @endif

                {{-- MODAL DELETE --}}
                <div class="modal fade" id="confirmationModal{{ $row->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content text-start">
                      <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                      </div>
                      <div class="modal-body">
                        Apakah anda yakin ingin menghapus <strong>{{ $row->name }}</strong>?
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('admin.users.delete', $row->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger">Hapus</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

              </td>
            </tr>
          @endforeach
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

$(document).ready(function(){
  $("#userSearchInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#dataTable tbody tr").filter(function() {
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
.modal-promote .modal-dialog {
  max-width: 640px;
}
.modal-promote .modal-body p {
  word-break: break-word;
  white-space: normal;
}
</style>

</body>
</html>
