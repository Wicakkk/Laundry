@extends('layouts.app')

@php
    $title = "Manage Customer";
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
                    <a href="{{ route('member.create') }}" class="btn btn-primary px-4">
                        <i class="bi bi-plus-lg me-2"></i>Add Customer
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
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Gender</th>
                                    <th>Phone Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $index => $member)
                                    <tr style="text-align: center">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $member->nama }}</td>
                                        <td>{{ $member->alamat }}</td>
                                        <td>{{ $member->jenis_kelamin == 'L' ? 'Male' : 'Female' }}</td>
                                        <td>{{ $member->tlp }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $member->id }}">Edit</button>
                                            <form action="{{ route('member.destroy', $member->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal{{ $member->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $member->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header border-bottom-0 py-2 bg-grd-info">
                                                    <h5 class="modal-title" id="editModalLabel{{ $member->id }}">Edit Customer</h5>
                                                    <a href="javascript:;" class="primary-menu-close" data-bs-dismiss="modal">
                                                        <i class="material-icons-outlined">close</i>
                                                    </a>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('member.update', $member->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="editNama{{ $member->id }}" class="form-label">Customer Name</label>
                                                            <input type="text" class="form-control" id="editNama{{ $member->id }}"
                                                                name="nama" value="{{ $member->nama }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="editAlamat{{ $member->id }}" class="form-label">Address</label>
                                                            <textarea class="form-control" id="editAlamat{{ $member->id }}"
                                                                name="alamat" required>{{ $member->alamat }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="editJenisKelamin{{ $member->id }}" class="form-label">Gender</label>
                                                            <select class="form-control" id="editJenisKelamin{{ $member->id }}"
                                                                name="jenis_kelamin" required>
                                                                <option value="L" {{ $member->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                                                    Male
                                                                </option>
                                                                <option value="P" {{ $member->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                                                    Female
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="editTlp{{ $member->id }}" class="form-label">Phone Number</label>
                                                            <input type="text" class="form-control" id="editTlp{{ $member->id }}"
                                                                name="tlp" value="{{ $member->tlp }}" required>
                                                        </div>
                                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                                            <button type="submit" class="btn btn-grd-danger px-4">Save</button>
                                                            <button type="button" class="btn btn-grd-info px-4" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal Edit -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
