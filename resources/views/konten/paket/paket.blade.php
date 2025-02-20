@extends('layouts.app')

@php
    $title = 'Manage Package';
@endphp

@section('content')
    <div class="container">
        <div class="row g-3">
            <div class="col-auto">
            </div>
            <div class="col-auto flex-grow-1 overflow-auto">
                <div class="btn-group position-static"></div>
            </div>
            @if (auth()->user()->role == 'admin')
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-2 justify-content-lg-end">
                        <a href="{{ route('paket.create') }}" class="btn btn-primary px-4">
                            <i class="bi bi-plus-lg me-2"></i>Add Package
                        </a>
                    </div>
                </div>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <div class="card mt-4">
            <div class="card-body">
                <div class="customer-table">
                    <div class="table-responsive white-space-nowrap">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr style="text-align: center">
                                    <th>No.</th>
                                    <th>Outlet</th>
                                    <th>Package Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pakets as $index => $paket)
                                    <tr style="text-align: center">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $paket->outlet->nama }}</td>
                                        <td>{{ $paket->nama_paket }}</td>
                                        <td>Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editModal"
                                                onclick="editOutlet({{ $paket->id }})">Edit</button>
                                            <form action="{{ route('outlet.destroy', $paket->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Apakah Anda yakin?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 py-2 bg-grd-info">
                    <h5 class="modal-title" id="editModalLabel">Edit Package</h5>
                    <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                        <i class="material-icons-outlined">close</i>
                    </a>
                </div>
                <div class="modal-body">
                    <form id="editPaketForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editPaketId" name="id">
                        <div class="mb-3">
                            <label for="editNamaPaket" class="form-label">Nama Paket</label>
                            <input type="text" class="form-control" id="editNamaPaket" name="nama_paket" required>
                        </div>
                        <div class="mb-3">
                            <label for="editJenis" class="form-label">Jenis</label>
                            <select class="form-select" id="editJenis" name="jenis" required>
                                <option value="kiloan">Kiloan</option>
                                <option value="selimut">Selimut</option>
                                <option value="bed_cover">Bed Cover</option>
                                <option value="kaos">Kaos</option>
                                <option value="lain">Lain</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editHarga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="editHarga" name="harga" required>
                        </div>
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="submit" class="btn btn-grd-danger px-4">Simpan</button>
                            <button type="button" class="btn btn-grd-info px-4" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
