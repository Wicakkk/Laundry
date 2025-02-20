@extends('layouts.app')

@php
    $title = 'Manage Users';
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
                    <a href="#" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="bi bi-plus-lg me-2"></i>Add User
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <div class="card mt-4">
            <div class="card-body">
                <div class="user-table">
                    <div class="table-responsive white-space-nowrap">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr style="text-align: center">
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Outlet</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users->where('role', 'kasir') as $index => $user)
                                    <tr style="text-align: center">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td>{{ $user->outlet->nama ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $user->id }}">Edit</button>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST"
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

                                    <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header border-bottom-0 py-2 bg-grd-info">
                                                    <h5 class="modal-title" id="editModalLabel{{ $user->id }}">Edit
                                                        User</h5>
                                                    <a href="javascript:;" class="primary-menu-close"
                                                        data-bs-dismiss="modal">
                                                        <i class="material-icons-outlined">close</i>
                                                    </a>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="editNama{{ $user->id }}"
                                                                class="form-label">Name</label>
                                                            <input type="text" class="form-control"
                                                                id="editNama{{ $user->id }}" name="nama"
                                                                value="{{ $user->nama }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="editUsername{{ $user->id }}"
                                                                class="form-label">Username</label>
                                                            <input type="text" class="form-control"
                                                                id="editUsername{{ $user->id }}" name="username"
                                                                value="{{ $user->username }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="editOutlet{{ $user->id }}"
                                                                class="form-label">Outlet</label>
                                                            <select class="form-control" id="editOutlet{{ $user->id }}"
                                                                name="id_outlet" required>
                                                                @foreach ($outlets as $outlet)
                                                                    <option value="{{ $outlet->id }}"
                                                                        {{ $user->id_outlet == $outlet->id ? 'selected' : '' }}>
                                                                        {{ $outlet->nama }}
                                                                    </option>
                                                                @endforeach
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 py-2 bg-grd-info">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <a href="javascript:;" class="primary-menu-close" data-bs-dismiss="modal">
                        <i class="material-icons-outlined">close</i>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="kasir">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_outlet" class="form-label">Outlet</label>
                            <select class="form-control" id="id_outlet" name="id_outlet" required>
                                @foreach ($outlets as $outlet)
                                    <option value="{{ $outlet->id }}">{{ $outlet->nama }}</option>
                                @endforeach
                            </select>
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
