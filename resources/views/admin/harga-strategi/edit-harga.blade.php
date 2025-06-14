@extends('layouts.app')

@section('title', 'Edit Harga Strategi')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Harga Strategi</h1>
        <a href="{{ route('admin.harga-strategi.analisis') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Harga</h6>
                </div>
                <div class="card-body">
                    <form id="updatePriceForm" method="POST" action="{{ route('admin.harga-strategi.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="currentPrice">Harga Saat Ini</label>
                            <input type="text" class="form-control" id="currentPrice" value="{{ $currentPrice ?? 0 }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="newPrice">Harga Baru</label>
                            <input type="number" class="form-control" id="newPrice" name="new_price" min="0" required>
                            <div id="priceError" class="invalid-feedback"></div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5>Panduan Update Harga:</h5>
                        <ul>
                            <li>Harga minimum yang diperbolehkan adalah Rp 0</li>
                            <li>Masukkan harga baru tanpa tanda titik atau koma</li>
                            <li>Sistem akan memvalidasi input secara otomatis</li>
                            <li>Pastikan harga yang dimasukkan sudah benar</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Alert -->
<div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
    <div id="successToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
        <div class="toast-header bg-success text-white">
            <strong class="mr-auto">Sukses</strong>
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            Harga berhasil diperbarui!
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('updatePriceForm');
    const newPriceInput = document.getElementById('newPrice');
    const priceError = document.getElementById('priceError');
    const submitBtn = document.getElementById('submitBtn');
    const successToast = document.getElementById('successToast');

    // Validasi real-time
    newPriceInput.addEventListener('input', function() {
        const price = parseInt(this.value);
        if (price < 0) {
            this.classList.add('is-invalid');
            priceError.textContent = 'Harga tidak boleh kurang dari 0';
            submitBtn.disabled = true;
        } else {
            this.classList.remove('is-invalid');
            priceError.textContent = '';
            submitBtn.disabled = false;
        }
    });

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const price = parseInt(newPriceInput.value);
        if (price < 0) {
            return;
        }

        // Submit form menggunakan AJAX
        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                new_price: price
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tampilkan toast
                $(successToast).toast('show');
                
                // Redirect setelah 2 detik
                setTimeout(() => {
                    window.location.href = "{{ route('admin.harga-strategi.analisis') }}";
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
</script>
@endpush