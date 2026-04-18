<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Order | Admin</title>
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

  @include('admin.topnavbar.topnav', ['title' => 'Order'])

  <div class="container-fluid py-4">
    <div class="card shadow mb-4">
      
      <div class="card-header py-3 d-flex justify-content-between align-items-center gap-3">
        <div>
          <h3 class="mb-2">Daftar Order</h3>
          <button class="btn btn-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#modalCreateOrder">
            <i class="material-symbols-rounded align-middle me-1">add</i>Tambah Order
          </button>
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
                      <button class="btn btn-bpttg-yellow btn-sm"
                              data-bs-toggle="modal"
                              data-bs-target="#modalEditOrder{{ $order->id }}">
                        <i class="material-symbols-rounded align-middle me-1">edit</i>Edit
                      </button>
                      <button class="btn btn-danger text-white btn-sm"
                              data-bs-toggle="modal"
                              data-bs-target="#modalDeleteOrder{{ $order->id }}">
                        <i class="material-symbols-rounded align-middle me-1">delete</i>Hapus
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

                <!-- Modal Edit -->
                <div class="modal fade jasa-edit-modal" id="modalEditOrder{{ $order->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title">Edit Order {{ $order->kode_order }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" enctype="multipart/form-data" class="order-form" data-prefix="edit" data-order-id="{{ $order->id }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                          <div class="row g-3">
                            <div class="col-md-3">
                              <label class="form-label fw-semibold">Kode Order</label>
                              <input type="text" class="form-control" value="{{ $order->kode_order }}" disabled>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label fw-semibold">ID Customer</label>
                              <input type="text" class="form-control order-id-customer-display" value="{{ $order->id_customer }}" disabled>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label fw-semibold">Nama Pemesan</label>
                              <select class="form-control order-customer-select"
                                      name="id_customer"
                                      required>
                                <option value="" disabled>-- Pilih Customer --</option>
                                @foreach ($customers as $customer)
                                  <option value="{{ $customer->id_customer }}"
                                          data-id="{{ $customer->id_customer }}"
                                          @selected($customer->id_customer === $order->id_customer)>
                                    {{ $customer->nama_pemesan }}
                                  </option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label fw-semibold">Nama Kemasan</label>
                              <textarea name="nama_kemasan" class="form-control" maxlength="100" rows="1" placeholder="Nama kemasan..." required>{{ $order->nama_kemasan }}</textarea>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label fw-semibold">Kondisi Desain</label>
                              <select name="kondisi_desain" class="form-control">
                                @foreach ($kondisiDesain as $key => $label)
                                  <option value="{{ $key }}" @selected($order->kondisi_desain == $key)>
                                    {{ $label }}
                                  </option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label fw-semibold">Status Desain</label>
                              <select name="status_desain" class="form-control">
                                @foreach ($statusDesain as $key => $label)
                                  <option value="{{ $key }}" @selected($order->status_desain == $key)>
                                    {{ $label }}
                                  </option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label fw-semibold">Upload File Desain Customer</label>
                              <input type="file" name="file_desain_customer" class="form-control">
                              @if($order->file_desain_customer)
                                <small>
                                  File saat ini:
                                  <a href="{{ asset('storage/' . $order->file_desain_customer) }}" target="_blank">
                                    Lihat File
                                  </a>
                                </small>
                              @endif
                            </div>
                            <div class="col-md-3">
                              <label class="form-label fw-semibold">Upload File Desain Mockup</label>
                              <input type="file" name="file_mockup" class="form-control">
                              @if($order->file_mockup)
                                <small>
                                  File saat ini:
                                  <a href="{{ asset('storage/' . $order->file_mockup) }}" target="_blank">
                                    Lihat File
                                  </a>
                                </small>
                              @endif
                              </div>
                              <div class="col-md-12">
                                <label class="form-label fw-semibold">Catatan Revisi Desain</label>
                                <textarea name="catatan_revisi" class="form-control" maxlength="2000" rows="3" placeholder="Catatan revisi desain...">{{ $order->catatan_revisi }}</textarea>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label fw-semibold">Tanggal Pesan</label>
                                <input type="date" name="tanggal_pesan" class="form-control" value="{{ $order->tanggal_pesan?->format('Y-m-d') }}" required>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label fw-semibold">Tanggal Target Selesai</label>
                                <input type="date" name="tanggal_target_selesai" class="form-control" value="{{ $order->tanggal_target_selesai?->format('Y-m-d') }}">
                              </div>
                              <div class="col-md-3">
                                <label class="form-label fw-semibold">Jasa</label>
                                <select class="form-control order-jasa-select"
                                        name="jasa_id"
                                        data-tarif-target="tarif-input-{{ $order->id }}"
                                        data-total-target="total-input-{{ $order->id }}"
                                        data-quantity-target="qty-input-{{ $order->id }}"
                                        >
                                  <option value="" selected>-- Pilih Jasa --</option>
                                  @foreach ($jasas as $jasa)
                                    <option value="{{ $jasa->id }}"
                                            data-tarif="{{ $jasa->tarif }}"
                                            @selected($jasa->id === $order->jasa_id)>
                                      {{ $jasa->nama_jasa }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label fw-semibold">Tarif</label>
                                <input type="number" class="form-control order-tarif-input" id="tarif-input-{{ $order->id }}" value="{{ $order->tarif }}" readonly>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label fw-semibold">Ukuran</label>
                                <textarea name="ukuran"
                                          class="form-control"
                                          rows="1"
                                          maxlength="256"
                                          placeholder="Contoh: 30x40 cm">{{ $order->ukuran }}</textarea>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label fw-semibold">Jumlah</label>
                                <input type="text"
                                      name="jumlah"
                                      class="form-control order-qty-input"
                                      id="qty-input-{{ $order->id }}"
                                      value="{{ $order->jumlah }}"
                                      oninput="
                                        this.value=this.value.replace(/[^0-9]/g,'');
                                        if(this.value.length>10)this.value=this.value.slice(0,10);
                                      "
                                      >
                              </div>
                              <div class="col-md-3">
                                <label class="form-label fw-semibold">Total Tagihan</label>
                                <input type="number" class="form-control order-total-input" id="total-input-{{ $order->id }}" value="{{ $order->total_tagihan }}" readonly>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label fw-semibold">Nominal DP (jika DP)</label>
                                <input type="number"
                                      name="dp_amount"
                                      class="form-control order-dp-input"
                                      id="dp-input-{{ $order->id }}"
                                      value="{{ $order->dp_amount }}"
                                      min="0"
                                      step="1"
                                      placeholder="Isi jika status DP">
                                <div class="form-text">Tanpa titik sebagai pemisah ribuan</div>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label fw-semibold">Sisa Tagihan</label>
                                <input type="number"
                                      class="form-control order-remaining-input"
                                      id="remaining-input-{{ $order->id }}"
                                      value="{{ $order->total_tagihan - $order->dp_amount }}"
                                      readonly>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label fw-semibold">Status Pembayaran</label>
                                <select name="status_pembayaran" class="form-control" required>
                                  @foreach ($statusPembayaran as $key => $label)
                                    <option value="{{ $key }}" @selected($order->status_pembayaran === $key)>{{ $label }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="col-md-3">
                              <label class="form-label fw-semibold">Jenis Pembayaran</label>
                              <select name="jenis_pembayaran" class="form-control">
                                @foreach ($jenisPembayaran as $key => $label)
                                  <option value="{{ $key }}" @selected($order->jenis_pembayaran == $key)>{{ $label }}</option>
                                @endforeach
                              </select>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label fw-semibold">Bukti Transfer</label>
                                <input type="file" name="bukti_transfer" class="form-control">
                                @if($order->bukti_transfer)
                                  <small>
                                    File saat ini:
                                    <a href="{{ asset('storage/' . $order->bukti_transfer) }}" target="_blank">
                                      Lihat File
                                    </a>
                                  </small>
                                @endif                            
                              </div>
                              <div class="col-md-3">
                                <label class="form-label fw-semibold">Tanggal Mulai Proses</label>
                                <input type="date" name="tanggal_mulai_proses" class="form-control" value="{{ $order->tanggal_mulai_proses?->format('Y-m-d') }}">
                              </div>
                              <div class="col-md-3">        
                                <label class="form-label fw-semibold">Tanggal Selesai Proses</label>
                                <input type="date" name="tanggal_selesai_proses" class="form-control" value="{{ $order->tanggal_selesai_proses?->format('Y-m-d') }}">
                              </div>
                              <div class="col-md-3">
                                <label class="form-label fw-semibold">Status Produksi</label>
                                <select name="status_produksi" class="form-control" required>
                                  @foreach ($statusProduksi as $key => $label)
                                    <option value="{{ $key }}" @selected($order->status_produksi === $key)>{{ $label }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="col-md-3">
                                <label class="form-label fw-semibold">Tanggal Diambil</label>
                                <input type="date" name="tanggal_diambil" class="form-control" value="{{ $order->tanggal_diambil?->format('Y-m-d') }}">
                              </div>
                              <div class="col-md-12">
                                <label class="form-label fw-semibold">Catatan</label>
                                <textarea name="catatan" class="form-control" maxlength="2000" rows="3" placeholder="Catatan tambahan...">{{ $order->catatan }}</textarea>
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
                <div class="modal fade jasa-edit-modal modal-delete" id="modalDeleteOrder{{ $order->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Hapus Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Yakin ingin menghapus <strong>{{ $order->kode_order }}</strong> milik {{ $order->nama_pemesan }}?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

              @empty
                <tr>
                  <td colspan="10" class="text-center py-4">
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

<!-- Modal Create -->
<div class="modal fade jasa-edit-modal" id="modalCreateOrder" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title">Tambah Data Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.orders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label fw-semibold">Kode Order</label>
              <input type="text" class="form-control" value="{{ $nextKodeOrder }}" readonly>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">ID Customer</label>
              <input type="text" class="form-control order-id-customer-display" id="createIdCustomerDisplay" readonly>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Nama Pemesan</label>
              <select class="form-control order-customer-select"
                      name="id_customer"
                      required>
                <option value="" selected disabled>-- Pilih Customer --</option>
                @foreach ($customers as $customer)
                  <option value="{{ $customer->id_customer }}" data-id="{{ $customer->id_customer }}">
                    {{ $customer->nama_pemesan }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Nama Kemasan</label>
              <textarea name="nama_kemasan" class="form-control" maxlength="100" rows="1" placeholder="Nama kemasan..." required></textarea>
            </div>
            <div class="col-md-3">
            <label class="form-label fw-semibold">Kondisi Desain</label>
              <select name="kondisi_desain" class="form-control" required>
                <option value="" selected disabled>-- Pilih Kondisi Desain --</option>
                @foreach ($kondisiDesain as $key => $label)
                  <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
            <label class="form-label fw-semibold">Status Desain</label>
            <select name="status_desain" id="statusDesainCreate" class="form-control" required>
              <option value="" selected disabled>-- Pilih Status Desain --</option>
              @foreach ($statusDesain as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
              @endforeach
            </select>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Upload File Desain Customer</label>
              <input type="file" name="file_desain_customer" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Upload File Desain Mockup
              </label>
              <input type="file" name="file_mockup" class="form-control">
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Catatan Revisi Desain</label>
              <textarea name="catatan_revisi" class="form-control" maxlength="2000" rows="3" placeholder="Wajib isi jika status perlu revisi"></textarea>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Tanggal Pesan</label>
              <input type="date" name="tanggal_pesan" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Tanggal Target Selesai</label>
              <input type="date" name="tanggal_target_selesai" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Jasa</label>
              <select class="form-control order-jasa-select"
                      name="jasa_id"
                      data-tarif-target="createTarif"
                      data-total-target="createTotal"
                      data-quantity-target="createJumlah"
                      required>
                <option value="" selected disabled>-- Pilih Jasa --</option>
                @foreach ($jasas as $jasa)
                  <option value="{{ $jasa->id }}" data-tarif="{{ $jasa->tarif }}">
                    {{ $jasa->nama_jasa }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Tarif</label>
              <input type="number" class="form-control order-tarif-input" id="createTarif" readonly>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Ukuran</label>
              <textarea name="ukuran"
                        class="form-control"
                        rows="1"
                        maxlength="256"
                        placeholder="Contoh: 30x40 cm"></textarea>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Jumlah</label>
              <input type="text"
                    name="jumlah"
                    class="form-control order-qty-input"
                    id="createJumlah"
                    oninput="
                      this.value=this.value.replace(/[^0-9]/g,'');
                      if(this.value.length>10)this.value=this.value.slice(0,10);
                    "
                    required>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Total Tagihan</label>
              <input type="number" class="form-control order-total-input" id="createTotal" readonly>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Nominal DP (jika DP)</label>
              <input type="number"
                     name="dp_amount"
                     class="form-control order-dp-input"
                     id="createDp"
                     min="0"
                     step="1"
                     placeholder="Isi jika status DP">
              <div class="form-text">Tanpa titik sebagai pemisah ribuan</div>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Sisa Tagihan</label>
              <input type="number" class="form-control order-remaining-input" id="createSisa" readonly>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Status Pembayaran</label>
              <select name="status_pembayaran" class="form-control" required>
                @foreach ($statusPembayaran as $key => $label)
                  <option value="{{ $key }}" @selected($key === 1)>{{ $label }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
            <label class="form-label fw-semibold">Jenis Pembayaran</label>
              <select name="jenis_pembayaran" class="form-control" required>
                <option value="" disabled selected>-- Pilih Jenis Pembayaran --</option>
                @foreach ($jenisPembayaran as $key => $label)
                  <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Upload Bukti Transfer</label>
              <input type="file" name="bukti_transfer" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Tanggal Mulai Proses</label>
              <input type="date" name="tanggal_mulai_proses" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Tanggal Selesai Proses</label>
              <input type="date" name="tanggal_selesai_proses" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Status Produksi</label>
              <select name="status_produksi" class="form-control" required>
                @foreach ($statusProduksi as $key => $label)
                  <option value="{{ $key }}" @selected($key === 1)>{{ $label }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Tanggal Diambil</label>
              <input type="date" name="tanggal_diambil" class="form-control">
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Catatan</label>
              <textarea name="catatan" class="form-control" maxlength="2000" rows="3" placeholder="Catatan tambahan..."></textarea>
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
    // Mark create + edit order forms and handle all validation via JS (notif dekat field)
    const $orderForms = $('form').has('select[name="kondisi_desain"]');
    $orderForms.addClass('order-form').attr('novalidate', true);

    const ORDER = {
      KONDISI_DESAIN_BELUM: '1',
      KONDISI_DESAIN_SUDAH: '2',
      STATUS_DESAIN_MENUNGGU: '1',
      STATUS_DESAIN_REVISI: '2',
      STATUS_DESAIN_DISETUJUI: '3',
      STATUS_PEMBAYARAN_BELUM: '1',
      STATUS_PEMBAYARAN_LUNAS: '2',
      STATUS_PEMBAYARAN_DP: '3',
      JENIS_PEMBAYARAN_CASH: '1',
      JENIS_PEMBAYARAN_TRANSFER: '2',
      STATUS_PRODUKSI_BELUM: '1',
      STATUS_PRODUKSI_DIPROSES: '2',
      STATUS_PRODUKSI_SELESAI: '3',
    };

    const getInput = (form, name) => form.find(`[name="${name}"]`).first();
    const getValue = (form, name) => getInput(form, name).val();

    const isDesignApproved = (form) => {
      const kondisi = parseInt(getInput(form, 'kondisi_desain').val());
      const status  = parseInt(getInput(form, 'status_desain').val());

      return kondisi === 2 && status === 3;
    };

    const setRequired = (input, required) => {
      if (!input.length) return;
      input.prop('required', !!required);
    };

    const clearFormErrors = (form) => {
      // cleanup legacy inline errors (sebelumnya pakai invalid-feedback)
      form.find('.is-invalid').removeClass('is-invalid').removeAttr('aria-invalid');
      form.find('.invalid-feedback.js-order-feedback').remove();
    };

    const REQUIRED_MESSAGE = 'Wajib diisi';
    const MIN_JUMLAH_MESSAGE = 'Minimal 1';
    const INVALID_STATUS_PRODUKSI_MESSAGE = 'Status produksi "Sedang diproses" / "Selesai" hanya bisa dipilih jika desain sudah ada dan disetujui.';

    const clearCustomValidityAll = (form) => {
      form.find(':input').each(function () {
        if (this && typeof this.setCustomValidity === 'function') {
          this.setCustomValidity('');
        }
      });
    };

    const setCustomValidity = (input, message) => {
      if (!input.length) return;
      const el = input[0];
      if (el && typeof el.setCustomValidity === 'function') {
        el.setCustomValidity(message || '');
      }
    };

    const hasExistingFileLink = (input) => {
      if (!input.length) return false;
      const container = input.closest('.col-md-3, .col-md-6, .col-12, .col-md-12');
      return container.find('a[target="_blank"]').length > 0;
    };

    const applyOrderRules = (form) => {
      // 8) Status desain otomatis "Menunggu desain" jika kondisi belum ada desain
      const kondisi = getValue(form, 'kondisi_desain');
      const statusDesainSelect = getInput(form, 'status_desain');
      if (statusDesainSelect.length) {
        statusDesainSelect.find('option').prop('disabled', false);
        if (kondisi === ORDER.KONDISI_DESAIN_BELUM) {
          statusDesainSelect.val(ORDER.STATUS_DESAIN_MENUNGGU);
          statusDesainSelect
            .find(`option:not([value="${ORDER.STATUS_DESAIN_MENUNGGU}"])`)
            .prop('disabled', true);
        }
      }

      // 9) Catatan revisi wajib jika status perlu revisi
      const statusDesain = getValue(form, 'status_desain');
      setRequired(getInput(form, 'catatan_revisi'), statusDesain === ORDER.STATUS_DESAIN_REVISI);

      // 3) Detail order wajib jika desain sudah ada + disetujui
      const designApproved = isDesignApproved(form);
      const jasaSelected = String(getValue(form, 'jasa_id') || '').trim() !== '';
      setRequired(getInput(form, 'jasa_id'), designApproved);
      setRequired(getInput(form, 'jumlah'), designApproved && jasaSelected);
      setRequired(getInput(form, 'status_pembayaran'), designApproved);

      // DP wajib jika status DP (hanya saat desain disetujui)
      const statusPembayaran = getValue(form, 'status_pembayaran');
      setRequired(
        getInput(form, 'dp_amount'),
        designApproved && statusPembayaran === ORDER.STATUS_PEMBAYARAN_DP
      );

      // 1) Jenis pembayaran wajib jika status pembayaran DP / Lunas (hanya saat desain disetujui)
      const jenisWajib =
        designApproved &&
        (statusPembayaran === ORDER.STATUS_PEMBAYARAN_DP || statusPembayaran === ORDER.STATUS_PEMBAYARAN_LUNAS);
      setRequired(getInput(form, 'jenis_pembayaran'), jenisWajib);

      // 7) Status produksi (2/3) hanya bisa dipilih jika desain sudah ada + disetujui
      const statusProduksiSelect = getInput(form, 'status_produksi');
      if (statusProduksiSelect.length) {
        const lockAdvanced = !designApproved;
        statusProduksiSelect
          .find(`option[value="${ORDER.STATUS_PRODUKSI_DIPROSES}"], option[value="${ORDER.STATUS_PRODUKSI_SELESAI}"]`)
          .prop('disabled', lockAdvanced);
      }

      // 4) Tanggal produksi hanya bisa diisi jika desain disetujui
      // 5) Mulai wajib saat "Sedang diproses"
      // 6) Selesai wajib saat "Selesai"
      const mulai = getInput(form, 'tanggal_mulai_proses');
      const selesai = getInput(form, 'tanggal_selesai_proses');
      if (mulai.length) {
        if (!designApproved) {
          mulai.prop('disabled', true).prop('required', false);
        } else {
          mulai.prop('disabled', false);
        }
      }
      if (selesai.length) {
        if (!designApproved) {
          selesai.prop('disabled', true).prop('required', false);
        } else {
          selesai.prop('disabled', false);
        }
      }

      if (designApproved) {
        const statusProduksi = getValue(form, 'status_produksi');
        setRequired(mulai, statusProduksi === ORDER.STATUS_PRODUKSI_DIPROSES);
        setRequired(selesai, statusProduksi === ORDER.STATUS_PRODUKSI_SELESAI);
      }
    };

    const syncOrderValidityMessages = (form) => {
      clearFormErrors(form);
      clearCustomValidityAll(form);
      applyOrderRules(form);

      // Default message untuk semua required field (tooltip validation)
      form.find(':input[required]').each(function () {
        if (!this || this.disabled || typeof this.setCustomValidity !== 'function') {
          return;
        }

        if (this.validity && this.validity.valueMissing) {
          this.setCustomValidity(REQUIRED_MESSAGE);
        }
      });

      // jumlah: minimal 1
      const jumlahEl = getInput(form, 'jumlah')[0];
      if (jumlahEl && !jumlahEl.disabled && typeof jumlahEl.setCustomValidity === 'function') {
        if (!jumlahEl.validity.valueMissing && jumlahEl.validity.rangeUnderflow) {
          jumlahEl.setCustomValidity(MIN_JUMLAH_MESSAGE);
        }
      }

      // 7) Status produksi (2/3) hanya jika desain disetujui (safety)
      const designApproved = isDesignApproved(form);
      const statusProduksi = getValue(form, 'status_produksi');
      // if (!designApproved && (statusProduksi === ORDER.STATUS_PRODUKSI_DIPROSES || statusProduksi === ORDER.STATUS_PRODUKSI_SELESAI)) {
      //   setCustomValidity(getInput(form, 'status_produksi'), INVALID_STATUS_PRODUKSI_MESSAGE);
      // }

      // 2) Bukti transfer wajib jika jenis pembayaran transfer (DP / Lunas)
      const statusPembayaran = getValue(form, 'status_pembayaran');
      const jenisPembayaran = getValue(form, 'jenis_pembayaran');
      const needsBuktiTransfer =
        designApproved &&
        (statusPembayaran === ORDER.STATUS_PEMBAYARAN_DP || statusPembayaran === ORDER.STATUS_PEMBAYARAN_LUNAS) &&
        jenisPembayaran === ORDER.JENIS_PEMBAYARAN_TRANSFER;

      if (needsBuktiTransfer) {
        const bukti = getInput(form, 'bukti_transfer');
        const hasNew = bukti[0] && bukti[0].files && bukti[0].files.length > 0;
        const hasExisting = hasExistingFileLink(bukti);
        if (!hasNew && !hasExisting) {
          setCustomValidity(bukti, REQUIRED_MESSAGE);
        }
      }

      const formEl = form[0];
      if (!formEl || typeof formEl.checkValidity !== 'function') {
        return true;
      }

      return formEl.checkValidity();
    };

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

    // clear error when user edits field
    $(document).on('input change', '.order-form :input', function() {
      if (this && typeof this.setCustomValidity === 'function') {
        this.setCustomValidity('');
      }
      const input = $(this);
      input.removeClass('is-invalid').removeAttr('aria-invalid');
      const fieldName = input.attr('name') || '';
      if (fieldName) {
        input.siblings(`.invalid-feedback.js-order-feedback[data-for="${fieldName}"]`).remove();
      }
    });

    // apply rules when key fields change
    $(document).on('change', 'select[name="kondisi_desain"], select[name="status_desain"], select[name="status_produksi"], select[name="status_pembayaran"], select[name="jenis_pembayaran"]', function() {
      const form = $(this).closest('form');
      clearFormErrors(form);
      clearCustomValidityAll(form);
      applyOrderRules(form);
    });

    // custom validation on submit (notif muncul di field saat klik Simpan)
    $(document).on('submit', 'form.order-form', function(e) {
      const form = $(this);
      const isValid = syncOrderValidityMessages(form);
      if (!isValid) {
        e.preventDefault();
        e.stopPropagation();

        if (typeof this.reportValidity === 'function') {
          this.reportValidity();
        }

        const firstInvalid = this.querySelector(':invalid');
        if (firstInvalid && typeof firstInvalid.focus === 'function') {
          firstInvalid.focus();
        }
      }
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
      applyOrderRules(form);
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
      applyOrderRules(form);
    });

    // initial recalc for forms (edit modals already in DOM)
    $('.order-form').each(function(){
      const form = $(this);
      recalcTotal(form);
      applyOrderRules(form);
    });
    $('.order-form').each(function(){
      const form = $(this);
      recalcTotal(form);
      applyOrderRules(form);
    });
    $(document).on('shown.bs.modal', '.jasa-edit-modal', function () {
      const form = $(this).find('form');
      if (form.length) {
        recalcTotal(form);
        applyOrderRules(form);
      }
    });        
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
</style>

</body>
</html>
