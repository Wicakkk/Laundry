@extends('layouts.app')

@php
    $title = "Add Customer";
@endphp

@section('content')
    <div class="container">
        <h2 class="my-4">Add Member</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('member.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Member Name</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Address</label>
                        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Gender</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="L">Male</option>
                            <option value="P">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tlp" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="tlp" name="tlp" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('member.index') }}" class="btn btn-danger">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
