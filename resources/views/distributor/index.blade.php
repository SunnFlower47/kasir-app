@extends('layouts.admin')

@section('title', 'Daftar Distributor')

@section('content')
    <h1>Daftar Distributor</h1>
    <a href="{{ route('distributor.create') }}">Tambah Distributor</a>
    <table border="1">
        <tr>
            <th>Nama Distributor</th>
            <th>Aksi</th>
        </tr>
        @foreach ($distributors as $distributor)
        <tr>
            <td>{{ $distributor->nama }}</td>
            <td>
                <a href="{{ route('distributor.edit', $distributor->id) }}">Edit</a>
                <form action="{{ route('distributor.destroy', $distributor->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
