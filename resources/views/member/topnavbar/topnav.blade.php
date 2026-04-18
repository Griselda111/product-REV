<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl">
  <div class="container-fluid py-1 px-3">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0">
      <li class="breadcrumb-item text-sm">Pages</li>
      <li class="breadcrumb-item text-sm text-dark active">{{ $title ?? 'Dashboard' }}</li>
    </ol>

    <div class="ms-auto d-flex align-items-center">
      <a href="{{ route('member.profile.edit') }}"
         class="d-flex align-items-center text-body profile-link px-3 py-1">
        <img src="{{ asset('assets/img/img_avatar.png') }}" class="avatar avatar-sm rounded-circle me-2 shadow-sm" alt="Profile">
        <span class="d-none d-sm-inline fw-semibold">Profil</span>
        <i class="material-symbols-rounded ms-1 text-secondary">chevron_right</i>
      </a>
    </div>
  </div>
</nav>

<style>
  .profile-link {
    border: 1px solid #e5e7eb;
    border-radius: 999px;
    transition: background 0.2s, box-shadow 0.2s;
  }
  .profile-link:hover {
    background: #f7f7f9;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
  }
</style>
