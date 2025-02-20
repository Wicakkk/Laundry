@extends('layouts.app')

@php
    $title = 'Add Outlet';
@endphp

@section('content')
    <div class="container">
        <h2 class="my-4">Add Outlet</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('outlet.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Outlet Name</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Address</label>
                        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tlp" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="tlp" name="tlp" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('outlet.index') }}" class="btn btn-danger">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
