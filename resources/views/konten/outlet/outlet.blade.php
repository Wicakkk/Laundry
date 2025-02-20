@extends('layouts.app')

@php
    $title = "Manage Outlet";
@endphp

@section('content')
    <div class="container">
        <div class="row g-3">
            <div class="col-auto">
            </div>
            <div class="col-auto flex-grow-1 overflow-auto">
                <div class="btn-group position-static"></div>
            </div>
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2 justify-content-lg-end">
                    <a href="{{ route('outlet.create') }}" class="btn btn-primary px-4">
                        <i class="bi bi-plus-lg me-2"></i>Add Outlet
                    </a>
                </div>
            </div>
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
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Phone Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($outlets as $index => $outlet)
                                    <tr style="text-align: center">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $outlet->nama }}</td>
                                        <td>{{ $outlet->alamat }}</td>
                                        <td>{{ $outlet->tlp }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editModal"
                                                onclick="editOutlet({{ $outlet->id }})">Edit</button>
                                            <form action="{{ route('outlet.destroy', $outlet->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Apakah Anda yakin?')">Delet</button>
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

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 py-2 bg-grd-info">
                    <h5 class="modal-title" id="editModalLabel">Edit Outlet</h5>
                    <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                        <i class="material-icons-outlined">close</i>
                    </a>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="editNama" class="form-label">Nama Outlet</label>
                            <input type="text" class="form-control" id="editNama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAlamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="editAlamat" name="alamat" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editTlp" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="editTlp" name="tlp" required>
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

    <script>
        function editOutlet(id) {
            fetch(`/outlet/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editForm').action = `/outlet/${id}`;
                    document.getElementById('editNama').value = data.nama;
                    document.getElementById('editAlamat').value = data.alamat;
                    document.getElementById('editTlp').value = data.tlp;
                });
        }
    </script>
@endsection
