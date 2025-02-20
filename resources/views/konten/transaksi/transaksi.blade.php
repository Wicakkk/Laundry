@extends('layouts.app')

@php
    $title = 'Manage Transaction';
@endphp

@section('content')
    <div class="container">
        <div class="row g-3">
            <div class="col-auto"></div>
            <div class="col-auto flex-grow-1 overflow-auto">
                <div class="btn-group position-static"></div>
            </div>
            @if (auth()->user()->role === 'admin' || auth()->user()->role === 'kasir')
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2 justify-content-lg-end">
                    <a href="{{ route('transaksi.create') }}" class="btn btn-primary px-4">
                        <i class="bi bi-plus-lg me-2"></i> Add Transaction
                    </a>
                </div>
            </div>
            @endif
        </div>

        <div class="d-flex gap-2 mt-3">
            <a href="{{ route('export.pdf') }}" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
            <a href="{{ route('export.excel') }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <div class="card mt-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table align-middle">
                        <thead class="table-light">
                            <tr style="text-align: center">
                                <th>No</th>
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Outlet</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Total Harga</th>
                                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'kasir')
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $index => $transaksi)
                                @php
                                    // Hitung subtotal
                                    $subtotal = $transaksi->details->sum(fn($d) => $d->paket->harga * $d->qty);
                                    $diskon = $subtotal * ($transaksi->diskon / 100);
                                    $total_sementara = $subtotal - $diskon;
                                    $total = $total_sementara + $transaksi->pajak + $transaksi->biaya_tambahan;
                                @endphp
                                <tr style="text-align: center">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $transaksi->kode_invoice }}</td>
                                    <td>{{ $transaksi->member->nama }}</td>
                                    <td>{{ $transaksi->outlet->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaksi->batas_waktu)->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($transaksi->status == 'baru')
                                            <span class="badge bg-grd-primary">NEW</span>
                                        @elseif ($transaksi->status == 'proses')
                                            <span class="badge bg-grd-info text-dark">PROCESS</span>
                                        @elseif ($transaksi->status == 'selesai')
                                            <span class="badge bg-grd-voilet">FINISH</span>
                                        @elseif ($transaksi->status == 'diambil')
                                            <span class="badge bg-grd-success">TAKEN</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($transaksi->dibayar == 'dibayar')
                                            <span class="badge bg-grd-success">PAID</span>
                                        @else
                                            <span class="badge bg-grd-danger">UNPAID</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'kasir')
                                    <td>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#viewModal{{ $transaksi->id }}">View</button>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $transaksi->id }}">Edit</button>
                                        <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this transaction?')">Delete</button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>

                                <!-- Modal Edit Transaksi -->
                                <div class="modal fade" id="editModal{{ $transaksi->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header border-bottom-0 py-2 bg-grd-info">
                                                <h5 class="modal-title" id="editModalLabel">Edit Transaction</h5>
                                                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                                                    <i class="material-icons-outlined">close</i>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('transaksi.update', $transaksi->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-3">
                                                        <label for="editOutlet{{ $transaksi->id }}"
                                                            class="form-label">Outlet</label>
                                                        <select class="form-control" id="editOutlet{{ $transaksi->id }}"
                                                            name="id_outlet" required>
                                                            @foreach ($outlets as $outlet)
                                                                <option value="{{ $outlet->id }}"
                                                                    {{ $outlet->id == $transaksi->id_outlet ? 'selected' : '' }}>
                                                                    {{ $outlet->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editMember{{ $transaksi->id }}"
                                                            class="form-label">Customer</label>
                                                        <select class="form-control" id="editMember{{ $transaksi->id }}"
                                                            name="id_member" required>
                                                            @foreach ($members as $member)
                                                                <option value="{{ $member->id }}"
                                                                    {{ $member->id == $transaksi->id_member ? 'selected' : '' }}>
                                                                    {{ $member->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editBatasWaktu{{ $transaksi->id }}"
                                                            class="form-label">Deadline</label>
                                                        <input type="datetime-local" class="form-control"
                                                            id="editBatasWaktu{{ $transaksi->id }}" name="batas_waktu"
                                                            value="{{ \Carbon\Carbon::parse($transaksi->batas_waktu)->format('Y-m-d\TH:i') }}"
                                                            required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editStatus{{ $transaksi->id }}"
                                                            class="form-label">Status</label>
                                                        <select class="form-control" id="editStatus{{ $transaksi->id }}"
                                                            name="status" required>
                                                            <option value="baru"
                                                                {{ $transaksi->status == 'baru' ? 'selected' : '' }}>NEW
                                                            </option>
                                                            <option value="proses"
                                                                {{ $transaksi->status == 'proses' ? 'selected' : '' }}>
                                                                PROCESS</option>
                                                            <option value="selesai"
                                                                {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>
                                                                FINISH</option>
                                                            <option value="diambil"
                                                                {{ $transaksi->status == 'diambil' ? 'selected' : '' }}>
                                                                TAKEN</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editDibayar{{ $transaksi->id }}"
                                                            class="form-label">Payment Status</label>
                                                        <select class="form-control" id="editDibayar{{ $transaksi->id }}"
                                                            name="dibayar" required>
                                                            <option value="dibayar"
                                                                {{ $transaksi->dibayar == 'dibayar' ? 'selected' : '' }}>
                                                                PAID</option>
                                                            <option value="belum_dibayar"
                                                                {{ $transaksi->dibayar == 'belum_dibayar' ? 'selected' : '' }}>
                                                                UNPAID</option>
                                                        </select>
                                                    </div>

                                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                                        <button type="submit"
                                                            class="btn btn-grd-danger px-4">Save</button>
                                                        <button type="button" class="btn btn-grd-info px-4"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Detail Transaksi -->
                                <div class="modal fade" id="viewModal{{ $transaksi->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header border-bottom-0 bg-grd-primary py-2">
                                                <h5 class="modal-title">Transaction Details</h5>
                                                <a href="javascript:;" class="primaery-menu-close"
                                                    data-bs-dismiss="modal">
                                                    <i class="material-icons-outlined">close</i>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Invoice:</strong> {{ $transaksi->kode_invoice }}</p>
                                                <p><strong>Customer:</strong> {{ $transaksi->member->nama }}</p>
                                                <p><strong>Outlet:</strong> {{ $transaksi->outlet->nama }}</p>
                                                <p><strong>Status:</strong>
                                                    @if ($transaksi->status == 'baru')
                                                        <span class="badge bg-grd-primary">NEW</span>
                                                    @elseif ($transaksi->status == 'proses')
                                                        <span class="badge bg-grd-info text-dark">PROCESS</span>
                                                    @elseif ($transaksi->status == 'selesai')
                                                        <span class="badge bg-grd-voilet">FINISH</span>
                                                    @elseif ($transaksi->status == 'diambil')
                                                        <span class="badge bg-grd-success">TAKEN</span>
                                                    @endif
                                                </p>
                                                <p><strong>Payment Status:</strong>
                                                    @if ($transaksi->dibayar == 'dibayar')
                                                        <span class="badge bg-success">PAID</span>
                                                    @else
                                                        <span class="badge bg-danger">UNPAID</span>
                                                    @endif
                                                </p>


                                                <h6>Order Summary:</h6>
                                                <div class="order-summary">
                                                    <div class="card mb-0">
                                                        <div class="card-body">
                                                            <div class="card border bg-transparent shadow-none">
                                                                <div class="card-body">
                                                                    <p class="fs-5">Order Details</p>
                                                                    <div class="my-3 border-top"></div>
                                                                    @foreach ($transaksi->details as $detail)
                                                                        <div class="d-flex align-items-center gap-3">
                                                                            <div class="ps-2">
                                                                                <h6 class="mb-1">
                                                                                    <a href="javascript:;"
                                                                                        class="text-white">
                                                                                        {{ $detail->paket->nama_paket }}
                                                                                    </a>
                                                                                </h6>
                                                                                <div class="widget-product-meta">
                                                                                    <span class="me-2">Rp
                                                                                        {{ number_format($detail->paket->harga, 0, ',', '.') }}</span>
                                                                                    <span class="">x
                                                                                        {{ $detail->qty }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="my-3 border-top"></div>
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                            <div class="card border bg-transparent mb-0 shadow-none">
                                                                <div class="card-body">
                                                                    @php
                                                                        $subtotal = $transaksi->details->sum(
                                                                            fn($d) => $d->paket->harga * $d->qty,
                                                                        );
                                                                        $diskon =
                                                                            $subtotal * ($transaksi->diskon / 100);
                                                                        $total_sementara = $subtotal - $diskon;
                                                                        $total =
                                                                            $total_sementara +
                                                                            $transaksi->pajak +
                                                                            $transaksi->biaya_tambahan;
                                                                    @endphp

                                                                    <p class="mb-2">Subtotal: <span class="float-end">Rp
                                                                            {{ number_format($subtotal, 0, ',', '.') }}</span>
                                                                    </p>
                                                                    <p class="mb-2">Discount
                                                                        ({{ $transaksi->diskon }}%)
                                                                        : <span class="float-end">Rp
                                                                            {{ number_format($diskon, 0, ',', '.') }}</span>
                                                                    </p>
                                                                    <p class="mb-2">Tax: <span class="float-end">Rp
                                                                            {{ number_format($transaksi->pajak, 0, ',', '.') }}</span>
                                                                    </p>
                                                                    <p class="mb-2">Additional Cost: <span
                                                                            class="float-end">Rp
                                                                            {{ number_format($transaksi->biaya_tambahan, 0, ',', '.') }}</span>
                                                                    </p>
                                                                    <div class="my-3 border-top"></div>
                                                                    <h5 class="mb-0">Total: <span class="float-end">Rp
                                                                            {{ number_format($total, 0, ',', '.') }}</span>
                                                                    </h5>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top-0">
                                                <button type="button" class="btn btn-grd-danger"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
