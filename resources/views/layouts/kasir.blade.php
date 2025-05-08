<!DOCTYPE html>
<html>
<head>
    <title>Kasir Panel - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav>
        {{-- Navbar kasir --}}
        <ul>
            <li><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
            {{-- Tambah menu lain jika perlu --}}
        </ul>
    </nav>

    <div class="content">
        @yield('content')
    </div>
</body>
</html>
