@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h3>Daftar User Menunggu Persetujuan</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.approve', ['user' => $user->id, 'role' => 'kasir']) }}" style="display:inline;">
                            @csrf @method('PUT')
                            <button class="btn btn-success btn-sm">Setujui sebagai Kasir</button>
                        </form>
                        <form method="POST" action="{{ route('admin.users.approve', ['user' => $user->id, 'role' => 'admin']) }}" style="display:inline;">
                            @csrf @method('PUT')
                            <button class="btn btn-primary btn-sm">Setujui sebagai Admin</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
