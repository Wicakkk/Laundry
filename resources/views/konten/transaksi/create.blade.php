@extends('layouts.app')

@php
    $title = 'Add Transaction';
@endphp

@section('content')
    <div class="container">
        <h2 class="my-4">Add Transaction</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf

                    <!-- Outlet (otomatis dari user login) -->
                    <div class="mb-3">
                        <label class="form-label">Outlet</label>
                        <input type="text" class="form-control" value="{{ $outlet->nama }}" readonly>
                        <input type="hidden" name="id_outlet" value="{{ $outlet->id }}">
                    </div>

                    <!-- Customer -->
                    <div class="mb-3">
                        <label for="id_member" class="form-label">Customer</label>
                        <select class="form-control" id="id_member" name="id_member" required>
                            <option value="" disabled selected>Select Customer</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">{{ $member->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Deadline -->
                    <div class="mb-3">
                        <label for="batas_waktu" class="form-label">Deadline</label>
                        <input type="datetime-local" class="form-control" id="batas_waktu" name="batas_waktu" required>
                    </div>

                    <!-- Additional Cost -->
                    <div class="mb-3">
                        <label for="biaya_tambahan" class="form-label">Additional Cost</label>
                        <input type="number" class="form-control" id="biaya_tambahan" name="biaya_tambahan" min="0">
                    </div>

                    <!-- Discount -->
                    <div class="mb-3">
                        <label for="diskon" class="form-label">Discount (%)</label>
                        <input type="number" class="form-control" id="diskon" name="diskon" min="0"
                            max="100" step="0.01">
                    </div>

                    <!-- Handled By (otomatis user login) -->
                    <div class="mb-3">
                        <label class="form-label">Handled by</label>
                        <input type="text" class="form-control" value="{{ $user->nama }}" readonly>
                        <input type="hidden" name="id_user" value="{{ $user->id }}">
                    </div>

                    <!-- Laundry Package (Hanya Paket yang Ada di Outlet User) -->
                    <div class="mb-3">
                        <label class="form-label">Laundry Package</label>
                        <div id="paket-container">
                            <div class="paket-item d-flex align-items-center mb-2">
                                <select name="paket[0][id_paket]" class="form-control me-2" required>
                                    <option value="" disabled selected>Select Package</option>
                                    @foreach ($pakets as $paket)
                                        <option value="{{ $paket->id }}">{{ $paket->nama_paket }}</option>
                                    @endforeach
                                </select>

                                <input type="number" name="paket[0][qty]" class="form-control me-2" placeholder="Qty"
                                    min="1" required>

                                <button type="button" class="btn btn-danger remove-paket">X</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success mt-2" id="add-paket">+ Add Package</button>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-danger">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-paket').addEventListener('click', function() {
            let index = document.querySelectorAll('.paket-item').length;
            let paketContainer = document.getElementById('paket-container');

            let paketItem = document.createElement('div');
            paketItem.classList.add('paket-item', 'd-flex', 'align-items-center', 'mb-2');
            paketItem.innerHTML = `
                <select name="paket[${index}][id_paket]" class="form-control me-2" required>
                    <option value="" disabled selected>Select Package</option>
                    @foreach ($pakets as $paket)
                        <option value="{{ $paket->id }}">{{ $paket->nama_paket }}</option>
                    @endforeach
                </select>

                <input type="number" name="paket[${index}][qty]" class="form-control me-2" placeholder="Qty" min="1" required>

                <button type="button" class="btn btn-danger remove-paket">X</button>
            `;
            paketContainer.appendChild(paketItem);
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-paket')) {
                event.target.parentElement.remove();
            }
        });
    </script>
@endsection
