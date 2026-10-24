@extends('layouts.app')

@section('content')
<div class="container my-4">
    <!-- Header Halaman & Tombol Tambah -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Daftar Inventaris Produk</h3>
        <a href="{{ route('products.create') }}" class="btn btn-primary fw-bold">
            + Tambah Produk Baru
        </a>
    </div>

    <!-- Alert Sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Pencarian -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('products.index') }}" method="GET" class="row g-2">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama produk atau SKU..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">Cari Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data Produk -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">No</th>
                            <th>SKU</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga (Rp)</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $index => $product)
                            <tr>
                                <td class="ps-3">{{ $products->firstItem() + $index }}</td>
                                <td><span class="badge bg-secondary">{{ $product->sku }}</span></td>
                                <td class="fw-bold">{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'Tanpa Kategori' }}</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $product->stock > 5 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $product->stock }} Unit
                                    </span>
                                </td>
                                <td class="text-center">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning me-1 fw-bold">
                                        Edit
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $product->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger fw-bold">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Belum ada data produk. Klik tombol <strong>+ Tambah Produk Baru</strong> untuk menambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Navigasi Halaman / Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection