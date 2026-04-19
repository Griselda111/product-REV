<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Order | Member</title>
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

  @include('member.topnavbar.topnav', ['title' => 'Order'])

  <div class="container-fluid py-4">
    <div class="card shadow mb-4">
      
      <div class="card-header py-3 d-flex justify-content-between align-items-center gap-3">
        <div>
          <h3 class="mb-2">Daftar Order</h3>
        </div>

        <div class="input-group input-group-outline w-25">
          <span class="input-group-text bg-transparent">
            <i class="material-symbols-rounded text-secondary">search</i>
          </span>
          <input type="text" id="orderSearchInput" class="form-control" placeholder="Search anything...">
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
          <table class="table table-bordered" id="orderTable">
            <thead>
              <tr class="text-center" style="font-size:13px">
                <th>NO</th>
                <th>Kode Order</th>
                <th>Nama Pemesan</th>
                <th>Nama Kemasan</th>
                <th>Jasa</th>
                <th>Total Tagihan</th>
                <th>Sisa Tagihan</th>
                <th>Status Pembayaran</th>
                <th>Status Produksi</th>
                <th>Tindakan</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($orders as $order)
                <tr class="text-center" style="font-size:13px">
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $order->kode_order }}</td>
                  <td>{{ $order->nama_pemesan }}</td>
                  <td>{{ $order->nama_kemasan ?? '-' }}</td>
                  <td>{{ $order->jasa->nama_jasa ?? '-' }}</td>
                  <td>Rp {{ number_format($order->total_tagihan, 0, ',', '.') }}</td>
                  <td>Rp {{ number_format($order->total_tagihan - $order->dp_amount, 0, ',', '.') }}</td>
                  <td>{{ $order->status_pembayaran_label }}</td>
                  <td>{{ $order->status_produksi_label }}</td>
                  <td class="align-middle">
                    <div class="action-inline">
                      <button class="btn btn-success text-white btn-sm"
                              data-bs-toggle="modal"
                              data-bs-target="#modalDetailOrder{{ $order->id }}">
                        <i class="material-symbols-rounded align-middle me-1">visibility</i>Detail
                      </button>
                    </div>
                  </td>
                </tr>

                <!-- Modal Detail -->
                <div class="modal fade jasa-edit-modal" id="modalDetailOrder{{ $order->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">

                      <!-- Header -->
                      <div class="modal-header border-bottom">
                        <h5 class="modal-title fw-bold">Detail Order <span class="text-primary">{{ $order->kode_order }}</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <!-- Body -->
                      <div class="modal-body">
                        <div class="row g-4">

                          <!-- ================= CUSTOMER ================= -->
                          <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                              <h6 class="fw-bold mb-3 text-primary">Informasi Customer</h6>
                              <div class="row g-1">
                                <div class="col-md-3">
                                  <small class="text-muted">ID Customer</small>
                                  <div class="fw-bold">{{ $order->id_customer }}</div>
                                </div>
                                <div class="col-md-3">
                                  <small class="text-muted">Nama Pemesan</small>
                                  <div class="fw-bold">{{ $order->nama_pemesan }}</div>
                                </div>
                                <div class="col-md-3">
                                  <small class="text-muted">Kemasan</small>
                                  <div class="fw-bold">{{ $order->nama_kemasan ?? '-' }}</div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- ================= TANGGAL ================= -->
                          <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                              <h6 class="fw-bold mb-3 text-primary">Timeline</h6>
                              <div class="row g-1">
                                <div class="col-md-6">
                                  <small class="text-muted">Tanggal Pesan</small>
                                  <div>{{ $order->tanggal_pesan?->format('d M Y') ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                  <small class="text-muted">Target Selesai</small>
                                  <div>{{ $order->tanggal_target_selesai?->format('d M Y') ?? '-' }}</div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- ================= DESAIN ================= -->
                          <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                              <h6 class="fw-bold mb-3 text-primary">Desain</h6>
                              <div class="row g-2">
                                <div class="col-md-6">
                                  <small class="text-muted">Kondisi</small>
                                  <div>{{ $order->kondisi_desain_label }}</div>
                                </div>
                                <div class="col-md-6">
                                  <small class="text-muted">Status</small>
                                  <div>{{ $order->status_desain_label }}</div>
                                </div>
                                <div class="col-md-6">
                                  <small class="text-muted">File Customer</small><br>
                                  @if($order->file_desain_customer)
                                    <a href="{{ asset('storage/' . $order->file_desain_customer) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                      Lihat File
                                    </a>
                                  @else
                                    -
                                  @endif
                                </div>

                                <div class="col-md-6">
                                  <small class="text-muted">Mockup</small><br>
                                  @if($order->file_mockup)
                                    <a href="{{ asset('storage/' . $order->file_mockup) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                      Lihat File
                                    </a>
                                  @else
                                    -
                                  @endif
                                </div>
                                <div class="col-md-6">
                                  <small class="text-muted">Catatan Revisi</small>
                                  <div class="mt-1">{{ $order->catatan_revisi ?? '-' }}</div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- ================= JASA ================= -->
                          <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                              <h6 class="fw-bold mb-3 text-primary">Detail Jasa</h6>
                              <div class="row g-2">

                                <div class="col-md-6">
                                  <small class="text-muted">Jasa</small>
                                  <div class="fw-semibold">{{ $order->jasa->nama_jasa ?? '-' }}</div>
                                </div>

                                <div class="col-md-6">
                                  <small class="text-muted">Tarif</small>
                                  <div class="fw-semibold text-success">
                                    Rp {{ number_format($order->tarif, 0, ',', '.') }}
                                  </div>
                                </div>

                                <!-- DETAIL BOX -->
                                <div class="col-md-4">
                                  <div class="p-3 border rounded-3 text-center bg-white">
                                    <small class="text-muted">Ukuran</small>
                                    <div class="fw-bold fs-6 d-flex align-items-center justify-content-center" style="min-height:35px;"> <!-- UPDATED -->
                                      {{ $order->ukuran ?? '-' }}
                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-4">
                                  <div class="p-3 border rounded-3 text-center bg-white">
                                    <small class="text-muted">Jumlah</small>
                                    <div class="fw-bold fs-6 d-flex align-items-center justify-content-center" style="min-height:35px;"> <!-- UPDATED -->
                                      {{ $order->jumlah ?? '-' }}
                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-4">
                                  <div class="p-3 rounded-3 text-center bg-white shadow-sm border border-primary-subtle">
                                    <small class="text-primary fw-semibold">Total</small> <!-- UPDATED -->
                                    <div class="fw-bold text-primary fs-5 d-flex align-items-center justify-content-center" style="min-height:35px;"> <!-- UPDATED -->
                                      {{ $order->total_tagihan ? 'Rp ' . number_format($order->total_tagihan, 0, ',', '.') : '-' }}
                                    </div>
                                  </div>
                                </div>

                              </div>
                            </div>
                          </div>


                          <!-- ================= PEMBAYARAN ================= -->
                          <div class="card border-0 shadow-sm mb-3"> <!-- UPDATED -->
                            <div class="card-body"> <!-- UPDATED -->
                              <h6 class="fw-bold mb-3 text-primary">Pembayaran</h6> <!-- UPDATED -->
                              <div class="row g-2"> <!-- UPDATED -->

                                <div class="col-md-6">
                                  <small class="text-muted">Status Pembayaran</small>
                                  <div class="fw-semibold"> <!-- UPDATED -->
                                    {{ $order->status_pembayaran_label }}
                                  </div>
                                </div>

                                <div class="col-md-6">
                                  <small class="text-muted">Jenis Pembayaran</small>
                                  <div class="fw-semibold"> <!-- UPDATED -->
                                    {{ $order->jenis_pembayaran_label}}
                                  </div>
                                </div>

                                <div class="col-md-12">
                                  <small class="text-muted">Bukti Transfer</small>
                                  <div class="mt-1"> <!-- UPDATED -->
                                    @if($order->bukti_transfer)
                                      <a href="{{ asset('storage/' . $order->bukti_transfer) }}" target="_blank" class="btn btn-sm btn-outline-primary"> <!-- UPDATED -->
                                        Lihat File
                                      </a>
                                    @else
                                      -
                                    @endif
                                  </div>
                                </div>

                                <div class="col-md-6"> <!-- UPDATED -->
                                  <div class="p-3 border rounded-3 text-center bg-white"> <!-- UPDATED -->
                                    <small class="text-muted">DP Dibayar</small>
                                    <div class="fw-bold text-success"> <!-- UPDATED -->
                                      Rp {{ number_format($order->dp_amount, 0, ',', '.') }}
                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-6"> <!-- UPDATED -->
                                  <div class="p-3 border rounded-3 text-center bg-white"> <!-- UPDATED -->
                                    <small class="text-muted">Sisa Tagihan</small>
                                    <div class="fw-bold text-danger"> <!-- UPDATED -->
                                      Rp {{ number_format($order->total_tagihan - $order->dp_amount, 0, ',', '.') }}
                                    </div>
                                  </div>
                                </div>

                              </div>
                            </div>
                          </div>

                          <!-- ================= PRODUKSI ================= -->
                          <div class="card border-0 shadow-sm mb-3"> <!-- UPDATED -->
                            <div class="card-body"> <!-- UPDATED -->
                              <h6 class="fw-bold mb-3 text-primary">Produksi</h6> <!-- UPDATED -->
                              <div class="row g-2"> <!-- UPDATED -->

                                <div class="col-md-6">
                                  <small class="text-muted">Status Produksi</small>
                                  <div class="fw-semibold"> <!-- UPDATED -->
                                    {{ $order->status_produksi_label }}
                                  </div>
                                </div>

                                <div class="col-md-6">
                                  <small class="text-muted">Tanggal Mulai Proses</small>
                                  <div>
                                    {{ $order->tanggal_mulai_proses?->format('d/m/Y') ?? '-' }}
                                  </div>
                                </div>

                                <div class="col-md-6">
                                  <small class="text-muted">Tanggal Selesai Proses</small>
                                  <div>
                                    {{ $order->tanggal_selesai_proses?->format('d/m/Y') ?? '-' }}
                                  </div>
                                </div>

                                <div class="col-md-6">
                                  <small class="text-muted">Tanggal Diambil</small>
                                  <div>
                                    {{ $order->tanggal_diambil?->format('d/m/Y') ?? '-' }}
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- ================= CATATAN ================= -->
                          <div class="card border-0 shadow-sm"> <!-- UPDATED -->
                            <div class="card-body"> <!-- UPDATED -->
                              <h6 class="fw-bold mb-2 text-primary">Catatan</h6> <!-- UPDATED -->
                              <div class="text-muted"> <!-- UPDATED -->
                                {{ $order->catatan ?? '-' }}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Footer -->
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                          Tutup
                        </button>
                      </div>

                    </div>
                  </div>
                </div>

              @empty
                <tr>
                  <td colspan="9" class="text-center py-4">
                    @if($statusLabel)
                      Tidak ada data order dengan status "{{ $statusLabel }}"
                    @else
                      Belum ada data order.
                    @endif
                  </td>
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
    $("#orderSearchInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#orderTable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });

    // update ID customer display when selecting name
    $(document).on('change', '.order-customer-select', function() {
      const selectedId = $(this).find('option:selected').data('id') || $(this).val();
      $(this).closest('form').find('.order-id-customer-display').val(selectedId);
    });

    // update tarif and total when selecting jasa or changing qty
    const recalcTotal = (form) => {
      const qtyInput = form.find('.order-qty-input').first();
      const tarifInput = form.find('.order-tarif-input').first();
      const totalInput = form.find('.order-total-input').first();
      const dpInput = form.find('.order-dp-input').first();
      const remainingInput = form.find('.order-remaining-input').first();
      const statusSelect = form.find('select[name="status_pembayaran"]').first();

      const qty = parseInt(qtyInput.val(), 10) || 0;
      const tarif = parseFloat(tarifInput.val()) || 0;
      const total = qty * tarif;
      totalInput.val(total);

      let dp = parseFloat(dpInput.val()) || 0;
      const status = statusSelect.val();
      if (status === '2') { // Lunas
        dp = total;
        dpInput.val(dp);
      } else if (status !== '3') { // Belum lunas
        dp = 0;
        dpInput.val(0);
      } else {
        dp = Math.min(dp, total);
        dpInput.val(dp);
      }

      if (remainingInput.length) {
        const remaining = Math.max(total - dp, 0);
        remainingInput.val(remaining);
      }
    };

    $(document).on('change', '.order-jasa-select', function() {
      const tarif = $(this).find('option:selected').data('tarif') || 0;
      const form = $(this).closest('form');
      form.find('.order-tarif-input').val(tarif);
      recalcTotal(form);
    });

    $(document).on('input', '.order-qty-input', function() {
      const form = $(this).closest('form');
      recalcTotal(form);
    });

    // update remaining when DP changes
    $(document).on('input', '.order-dp-input', function() {
      const form = $(this).closest('form');
      recalcTotal(form);
    });

    // status pembayaran change handler (Belum lunas / DP / Lunas)
    $(document).on('change', 'select[name="status_pembayaran"]', function() {
      const form = $(this).closest('form');
      recalcTotal(form);
    });

    // initial recalc for forms (edit modals already in DOM)
    $('.order-form').each(function(){ recalcTotal($(this)); });
  });
</script>

<style>
  .table { border-collapse: collapse !important; }
  .table td, .table th { border: 1px solid #0d0d0d !important; }
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
  .profile-link {
    border: 1px solid #e5e7eb;
    border-radius: 999px;
    transition: background 0.2s, box-shadow 0.2s;
  }
  .profile-link:hover {
    background: #f7f7f9;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
  }
  /* shared */
  /* Pastikan modal berada di atas sidebar dan tetap center */
  .modal.jasa-edit-modal {
    z-index: 2000;
    padding-left: 0 !important;
  }
  .modal.jasa-edit-modal .modal-dialog {
    margin-left: auto;
    margin-right: auto;
  }
  /* Shift modal to the right on desktop so it clears the fixed sidebar */
  @media (min-width: 992px) {
    .modal.jasa-edit-modal .modal-dialog {
      margin-left: 260px;
      margin-right: 16px;
      max-width: 1100px;
    }
    /* Keep delete modal centered and compact like customer modal */
    .modal.jasa-edit-modal.modal-delete .modal-dialog {
      margin-left: auto;
      margin-right: auto;
      max-width: 460px;
    }
  }
  .modal-backdrop.show {
    z-index: 1990;
  }
  /* Detail modal metric cards */
  .detail-card {
    background: #f8f9fb;
    border: 1px solid #e5e7ef;
    border-radius: 12px;
    padding: 12px 14px;
  }
  .detail-card .detail-label {
    font-size: 12px;
    letter-spacing: 0.2px;
    color: #8a8fa3;
    margin-bottom: 4px;
    text-transform: uppercase;
  }
  .detail-card .detail-value {
    font-weight: 700;
    color: #1f2335;
    font-size: 15px;
  }
  .detail-card.highlight {
    border-color: #c9d4ff;
    background: #f3f6ff;
  }
  /* Smaller delete confirmation */
  .modal-delete .modal-dialog {
    max-width: 460px;
  }
  .modal-delete .modal-content {
    border-radius: 14px;
  }
  .modal-delete .modal-header,
  .modal-delete .modal-footer {
    padding: 0.75rem 1rem;
  }
  .modal-delete .modal-body {
    padding: 0.5rem 1rem 1rem;
    font-size: 14px;
  }
  /* Action buttons: smaller + wrap to avoid horizontal scroll */
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
</style>

</body>
</html>
