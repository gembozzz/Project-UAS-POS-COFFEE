@extends('layouts/app')


@section('content') 
{{-- Alert --}}
@if (session('added_success'))
<div class="alert alert-success alert-dismissible text-white fade show" role="alert">
    <span class="alert-icon align-middle">
      <span class="material-symbols-rounded text-md">
      thumb_up_off_alt
      </span>
    </span>
    <span class="alert-text">{{ session('added_success') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<h4>Data Produk</h4>
<div class="card px-2 py-2">
    <div class="card-body">
        <button data-bs-toggle="modal" data-bs-target="#insertModal" class="btn btn-primary btn-md">Tambah Produk</button>
        <table class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Modal</th>
                    <th>Diskon</th>
                    <th>Harga Jual</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produks as $produk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $produk->kode_produk }}</td>
                    <td>{{ $produk->nama_produk }}</td>
                    <td>{{ $produk->kategori->nama_kategori }}</td>
                    <td>{{ format_uang($produk->harga_modal) }}</td>
                    <td>{{ $produk->diskon }}</td>
                    <td>{{ format_uang($produk->harga_jual) }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm"
                            data-bs-toggle="modal" 
                            data-bs-target="#editModal" 
                            data-id="{{ $produk->id_produk }}" 
                            data-kode="{{ $produk->kode_produk }}"
                            data-nama="{{ $produk->nama_produk }}"
                            data-kategori="{{ $produk->kategori->id_kategori }}"
                            data-harga_modal="{{ $produk->harga_modal }}"
                            data-diskon="{{ $produk->diskon }}"
                            data-harga_jual="{{ $produk->harga_jual }}">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal" 
                                data-id="{{ $produk->id_produk  }}">
                            Hapus
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>  
</div>

<!-- Modal tambah Produk -->
<div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('produk.store') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group input-group-outline my-3">
                        <label for="kode_produk" class="form-label">Kode Produk</label>
                        <input type="text" class="form-control" name="kode_produk">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" name="nama_produk">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <select class="form-control" id="id_kategori" name="id_kategori">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>                                    
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label for="harga_modal" class="form-label">Modal</label>
                        <input type="number" class="form-control" name="harga_modal">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label for="diskon" class="form-label">Diskon</label>
                        <input type="number" class="form-control" name="diskon" value="0">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <input type="number" class="form-control" name="harga_jual">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Produk -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editForm" method="post" action="">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group input-group-static my-3">
                        <label for="edit_kode_produk" class="ms-0">Kode Produk</label>
                        <input type="text" class="form-control" name="kode_produk" id="edit_kode_produk">
                    </div>
                    <div class="input-group input-group-static my-3">
                        <label for="edit_nama_produk" class="ms-0">Nama Produk</label>
                        <input type="text" class="form-control" name="nama_produk" id="edit_nama_produk">
                    </div>
                    <div class="input-group input-group-static my-3">
                        <label for="edit_id_kategori" class="ms-0">Kategori</label>
                        <select class="form-control" id="edit_id_kategori" name="id_kategori">
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group input-group-static my-3">
                        <label for="edit_harga_modal" class="ms-0">Modal</label>
                        <input type="number" class="form-control" name="harga_modal" id="edit_harga_modal">
                    </div>
                    <div class="input-group input-group-static my-3">
                        <label for="edit_diskon" class="ms-0">Diskon</label>
                        <input type="number" class="form-control" name="diskon" id="edit_diskon">
                    </div>
                    <div class="input-group input-group-static my-3">
                        <label for="edit_harga_jual" class="ms-0">Harga Jual</label>
                        <input type="number" class="form-control" name="harga_jual" id="edit_harga_jual">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- Modal Hapus Kategori --}}

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus produk ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('title')
Produk
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Tombol yang diklik
        var id = button.getAttribute('data-id'); // Ambil ID produk
        var kode = button.getAttribute('data-kode'); // Ambil kode produk
        var nama = button.getAttribute('data-nama'); // Ambil nama produk
        var kategori = button.getAttribute('data-kategori'); // Ambil kategori produk
        var hargamodal = button.getAttribute('data-harga_modal'); // Ambil harga modal produk
        var diskon = button.getAttribute('data-diskon'); // Ambil diskon produk
        var hargaJual = button.getAttribute('data-harga_jual'); // Ambil harga jual produk

        // Update form action URL untuk produk
        var form = document.getElementById('editForm');
        form.action = `/admin/produk/${id}`; // URL ini harus sesuai dengan rute resource

        // Update input value untuk form modal
        document.getElementById('edit_kode_produk').value = kode;
        document.getElementById('edit_nama_produk').value = nama;
        document.getElementById('edit_id_kategori').value = kategori;
        document.getElementById('edit_harga_modal').value = hargamodal;
        document.getElementById('edit_diskon').value = diskon;
        document.getElementById('edit_harga_jual').value = hargaJual;
    });
});

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Tombol yang diklik
            var id = button.getAttribute('data-id'); // Ambil ID dari tombol

            // Update form action URL
            var form = document.getElementById('deleteForm');
            form.action = `/admin/produk/${id}`; // Pastikan URL sesuai dengan rute resource
        });
    });
</script>
<script>
    new DataTable('#myTable');
</script>
@endpush