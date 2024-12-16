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

<h4>Data Member</h4>
<div class="card px-2 py-2">
    <div class="card-body">
        <button data-bs-toggle="modal" data-bs-target="#insertModal" class="btn btn-primary btn-md">Tambah Member</button>
        {{-- <a href="#" class="btn btn-success">Cetak Member</a> --}}
        <table id="myTable" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Member</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No Telepon</th>
                    <th>Diskon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $member->kode_member }}</td>
                    <td>{{ $member->nama }}</td>
                    <td>{{ $member->alamat }}</td>
                    <td>{{ $member->no_telp }}</td>
                    <td>{{ $member->diskon }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm"
                            data-bs-toggle="modal" 
                            data-bs-target="#editModal" 
                            data-id="{{ $member->id_member }}" 
                            data-kode_member="{{ $member->kode_member }}" 
                            data-nama="{{ $member->nama }}"
                            data-alamat="{{ $member->alamat }}"
                            data-no_telp="{{ $member->no_telp }}"
                            data-diskon="{{ $member->diskon }}">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal" 
                                data-id="{{ $member->id_member }}">
                            Hapus
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>  
</div>

<!-- Modal tambah Member -->
<div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('member.store') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group input-group-outline my-3">
                        <label for="kode_member" class="form-label">Kode Member</label>
                        <input type="text" class="form-control" name="kode_member">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label for="nama" class="form-label">Nama Member</label>
                        <input type="text" class="form-control" name="nama">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label for="no_telp" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" name="no_telp">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label for="diskon" class="form-label">Diskon</label>
                        <input type="number" class="form-control" name="diskon">
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

<!-- Modal Edit Member -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editForm" method="post" action="">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group input-group-static my-3">
                        <label for="edit_kode_member" class="ms-0">Kode Member</label>
                        <input type="text" class="form-control" name="kode_member" id="edit_kode_member">
                    </div>
                    <div class="input-group input-group-static my-3">
                        <label for="edit_nama" class="ms-0">Nama Member</label>
                        <input type="text" class="form-control" name="nama" id="edit_nama">
                    </div>
                    <div class="input-group input-group-static my-3">
                        <label for="edit_alamat" class="ms-0">Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="edit_alamat">
                    </div>
                    <div class="input-group input-group-static my-3">
                        <label for="edit_no_telp" class="ms-0">No Telepon</label>
                        <input type="text" class="form-control" name="no_telp" id="edit_no_telp">
                    </div>
                    <div class="input-group input-group-static my-3">
                        <label for="diskon" class="ms-0">Diskon</label>
                        <input type="number" class="form-control" name="diskon" id="edit_diskon">
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


{{-- Modal Hapus Member --}}

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
                    <p>Apakah Anda yakin ingin menghapus member ini?</p>
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
Member
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Tombol yang diklik
        var id = button.getAttribute('data-id'); // Ambil ID member
        var kode_member = button.getAttribute('data-kode_member'); // Ambil Kode member
        var nama = button.getAttribute('data-nama'); // Ambil nama member
        var alamat = button.getAttribute('data-alamat'); // Ambil alamat member
        var no_telp = button.getAttribute('data-no_telp'); // Ambil no_telp member
        var diskon = button.getAttribute('data-diskon'); // Ambil diskon member

        // Update form action URL untuk produk
        var form = document.getElementById('editForm');
        form.action = `/admin/member/${id}`; // URL ini harus sesuai dengan rute resource

        // Update input value untuk form modal
        document.getElementById('edit_kode_member').value = kode_member;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_alamat').value = alamat;
        document.getElementById('edit_no_telp').value = no_telp;
        document.getElementById('edit_diskon').value = diskon;
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
            form.action = `/admin/member/${id}`; // Pastikan URL sesuai dengan rute resource
        });
    });
</script>
    <script>
        new DataTable('#myTable');
    </script>
@endpush