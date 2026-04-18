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
                @php($sisaTagihan = round((float) $order->total_tagihan - (float) $order->dp_amount, 2))
                <tr class="text-center" style="font-size:13px">
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $order->kode_order }}</td>
                  <td>{{ $order->nama_pemesan }}</td>
                  <td>{{ $order->jasa->nama_jasa ?? '-' }}</td>
                  <td>Rp {{ $order->total_tagihan == (int)$order->total_tagihan ? number_format($order->total_tagihan, 0, ',', '') : number_format($order->total_tagihan, 2, ',', '') }}</td>
                  <td>Rp {{ $sisaTagihan == (int)$sisaTagihan ? number_format($sisaTagihan, 0, ',', '') : number_format($sisaTagihan, 2, ',', '') }}</td>
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
                      <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title">Detail Order {{ $order->kode_order }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row g-3">
                          <div class="col-md-6">
                            <div class="fw-semibold text-muted small">ID Customer</div>
                            <div class="fw-bold">{{ $order->id_customer }}</div>
                          </div>
                          <div class="col-md-6">
                            <div class="fw-semibold text-muted small">Nama Pemesan</div>
                            <div class="fw-bold">{{ $order->nama_pemesan }}</div>
                          </div>
                          <div class="col-md-6">
                            <div class="fw-semibold text-muted small">Tanggal Pesan</div>
                            <div>{{ $order->tanggal_pesan?->format('d/m/Y') ?? '-' }}</div>
                          </div>
                          <div class="col-md-6">
                            <div class="fw-semibold text-muted small">Target Selesai</div>
                            <div>{{ $order->tanggal_target_selesai?->format('d/m/Y') ?? '-' }}</div>
                          </div>
                          <div class="col-md-6">
                            <div class="fw-semibold text-muted small">Jasa</div>
                            <div>{{ $order->jasa->nama_jasa ?? '-' }}</div>
                          </div>
                          <div class="col-md-6">
                            <div class="fw-semibold text-muted small">Tarif</div>
                            <div>Rp {{ $order->tarif == (int)$order->tarif ? number_format($order->tarif, 0, ',', '') : number_format($order->tarif, 2, ',', '') }}</div>
                          </div>
                          <div class="col-md-12">
                            <div class="row g-2 align-items-stretch">
                              <div class="col-md-4">
                              <div class="detail-card h-100">
                                <div class="detail-label">Ukuran</div>
                                <div class="detail-value">{{ $order->ukuran }}</div>
                              </div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-card h-100">
                                  <div class="detail-label">Jumlah</div>
                                  <div class="detail-value">{{ $order->jumlah }}</div>
                                </div>
                              </div>
                            <div class="col-md-4">
                                <div class="detail-card h-100 highlight">
                                  <div class="detail-label">Total Tagihan</div>
                                  <div class="detail-value">Rp {{ $order->total_tagihan == (int)$order->total_tagihan ? number_format($order->total_tagihan, 0, ',', '') : number_format($order->total_tagihan, 2, ',', '') }}</div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="fw-semibold text-muted small">Status Pembayaran</div>
                            <div>{{ $order->status_pembayaran_label }}</div>
                          </div>
                          <div class="col-md-6">
                            <div class="fw-semibold text-muted small">Status Produksi</div>
                            <div>{{ $order->status_produksi_label }}</div>
                          </div>
                          <div class="col-md-6">
                            <div class="fw-semibold text-muted small">DP Dibayar</div>
                            <div>Rp {{ $order->dp_amount == (int)$order->dp_amount ? number_format($order->dp_amount, 0, ',', '') : number_format($order->dp_amount, 2, ',', '') }}</div>
                          </div>
                          <div class="col-md-6">
                            <div class="fw-semibold text-muted small">Sisa Tagihan</div>
                            <div>Rp {{ $sisaTagihan == (int)$sisaTagihan ? number_format($sisaTagihan, 0, ',', '') : number_format($sisaTagihan, 2, ',', '') }}</div>
                          </div>
                          <div class="col-md-6">
                            <div class="fw-semibold text-muted small">Tanggal Mulai Proses</div>
                            <div>{{ $order->tanggal_mulai_proses?->format('d/m/Y') ?? '-' }}</div>
                          </div>
                          <div class="col-md-6">
                            <div class="fw-semibold text-muted small">Tanggal Selesai Proses</div>
                            <div>{{ $order->tanggal_selesai_proses?->format('d/m/Y') ?? '-' }}</div>
                          </div>
                          <div class="col-md-6">
                            <div class="fw-semibold text-muted small">Tanggal Diambil</div>
                            <div>{{ $order->tanggal_diambil?->format('d/m/Y') ?? '-' }}</div>
                          </div>
                          <div class="col-md-12">
                            <div class="fw-semibold text-muted small">Catatan</div>
                            <div>{{ $order->catatan ?? '-' }}</div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
