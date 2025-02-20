@extends('layouts.app')

@php
    $title = 'Dashboard';
@endphp

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Dashboard</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item active" aria-current="page">{{ Auth::user()->nama }}</li>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-12 d-flex align-items-stretch">
            <div class="card w-100 overflow-hidden rounded-4">
                <div class="card-body position-relative p-4">
                    <div class="row">
                        <div class="col-12 col-sm-7">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <img src="assets/images/avatars/11.png" class="rounded-circle bg-grd-info p-1"
                                    width="60" height="60" alt="user">
                                <div class="">
                                    <p class="mb-0 fw-semibold fs-5">Good to see you, {{ Auth::user()->nama }}!</p>
                                    <p class=" mb-0">Let’s keep the momentum going! 🚀</p>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-start">
                                <p class="mb-1 fs-4">Total Sales : </p>
                                <h1 class="fw-bold display-3 text-success">Rp.
                                    {{ number_format($totalPendapatan, 0, ',', '.') }}</h1>
                            </div>
                        </div>

                        <div class="col-12 col-sm-5">
                            <div class="welcome-back-img pt-4">
                                <img src="assets/images/gallery/welcome-back-3.png" height="180" alt="">
                            </div>
                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-xxl-4 d-flex align-items-stretch">
            <div class="card w-100 rounded-4">
                <div class="card-header border-0 p-3 border-bottom">
                    <h5 class="mb-0">New Members</h5>
                </div>
                <div class="card-body p-0">
                    <div class="user-list p-3">
                        <div class="d-flex flex-column gap-3">
                            @foreach ($members as $member)
                                @php
                                    $avatar = asset('../assets/images/avatars/default.jpg');
                                    if ($member->jenis_kelamin === 'L') {
                                        $avatar = asset('../assets/images/avatars/1.jpg');
                                    } elseif ($member->jenis_kelamin === 'P') {
                                        $avatar = asset('../assets/images/avatars/2.jpg');
                                    }
                                @endphp
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $avatar }}" width="45" height="45" class="rounded-circle"
                                        alt="Avatar">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $member->nama }}</h6>
                                        <p class="mb-0">{{ $member->tlp }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-xxl-8 d-flex align-items-stretch">
            <div class="card w-100 rounded-4">
                <div class="card-body">
                    <h5 class="mb-3">Recent Orders</h5>
                    <div class="table-responsive">
                        <div class="order-search position-relative my-3">
                            <input class="form-control rounded-5 px-5" type="text" placeholder="Search">
                            <span
                                class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50">search</span>
                        </div>
                        <table class="table align-middle">
                            <thead>
                                <tr style="text-align: center">
                                    <th>No</th>
                                    <th>Invoice</th>
                                    <th>Member</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Deadline</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksis as $index => $transaksi)
                                    <tr style="text-align: center">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $transaksi->kode_invoice }}</td>
                                        <td>{{ $transaksi->member->nama }}</td>
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
                                        <td>{{ \Carbon\Carbon::parse($transaksi->batas_waktu)->format('d-m-Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    </div>
@endsection
