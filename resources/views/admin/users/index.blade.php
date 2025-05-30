@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen User</h1>
        <a href="{{ route('admin.users.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah User
        </a>
    </div>

```
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if(isset($user->role))
                                <span class="badge badge-{{ $user->role == 'admin' ? 'primary' : 'success' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            @else
                                <span class="badge badge-danger">Role tidak ditemukan</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-role"
                                    data-toggle="modal" data-target="#roleModal"
                                    data-userid="{{ $user->id }}"
                                    data-currentrole="{{ $user->role }}">
                                <i class="fas fa-user-cog"></i>
                            </button>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus user ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
```

</div>

<!-- Role Modal -->

<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Role User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="roleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
$(document).ready(function() {
    // Inisialisasi DataTable
    $('#dataTable').DataTable();

    // Handle modal role
    $('#roleModal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);  // Tombol yang memicu modal
    const userId = button.data('userid');  // ID User

    // Mengarahkan form ke URL yang benar
    const url = "{{ route('admin.users.role', ':id') }}".replace(':id', userId);
    $('#roleForm').attr('action', url);
});
$('#roleForm').submit(function (e) {
    e.preventDefault();
    const form = $(this);
    const url = form.attr('action');

    $.ajax({
        type: "POST", // Gunakan POST
        url: url,
        data: form.serialize() + '&_method=PUT', // Tambahkan _method=PUT
        success: function (response) {
            $('#roleModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: response.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => location.reload());
        },
        error: function (xhr) {
            let message = 'Terjadi kesalahan.';
            if (xhr.responseJSON?.errors) {
                message = Object.values(xhr.responseJSON.errors).join(', ');
            } else if (xhr.responseJSON?.message) {
                message = xhr.responseJSON.message;
            }

            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: message
            });
        }
    });
});
});

</script>

@endsection
