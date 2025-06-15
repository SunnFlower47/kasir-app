@extends('layouts.kasir')

@section('content')
<div class="container mx-auto p-6 bg-gray-100 min-h-screen">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Katalog Produk -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">🛒 Pilih Produk</h2>
                <input type="text" id="search" placeholder="Cari produk..."
                    class="w-full px-4 py-2 mb-6 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <!-- Produk List -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 max-h-[70vh] overflow-y-auto produk-list">
                    @foreach($produks as $produk)
                    <div class="bg-gray-50 hover:bg-white rounded-xl p-4 border hover:border-blue-400 cursor-pointer transition duration-200"
                        onclick="tambahKeKeranjang({{ $produk->id }}, '{{ $produk->nama }}', {{ $produk->harga_jual }})">
                        <h4 class="font-semibold text-lg text-gray-800">{{ $produk->nama }}</h4>
                        <p class="text-sm text-gray-500">Stok: <span class="stok-{{ $produk->id }}">{{ $produk->stok }}</span> {{ $produk->satuan }}</p>
                        <p class="text-blue-600 font-bold text-base mt-2">Rp {{ number_format($produk->harga_jual) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Panel Keranjang -->
        <div class="bg-white rounded-2xl shadow p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-xl font-bold mb-4 text-gray-800">🧺 Keranjang</h3>
                <ul id="keranjang" class="space-y-4 max-h-[50vh] overflow-y-auto">
                    <!-- Item keranjang muncul di sini -->
                </ul>
            </div>

            <div class="mt-6 border-t pt-4">
                <div class="flex justify-between items-center text-lg font-semibold text-gray-700 mb-2">
                    <span>Total:</span>
                    <span id="totalHarga" class="text-green-600">Rp 0</span>
                </div>
                <input type="number" id="uang_bayar" placeholder="Uang bayar"
                    class="w-full mb-2 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500">
                <div class="text-right text-sm text-gray-600 mb-3">Kembalian: <span id="kembalian" class="text-red-500">Rp 0</span></div>
                <button id="btnSimpan"
                    class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">💾 Bayar & Simpan</button>
                <button id="btnCetak"
                    class="w-12 h-12 flex justify-center items-center bg-blue-600 text-white rounded-full hover:bg-blue-700 transition mt-2 hidden"
                    title="Cetak Struk">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-3h20v3a2 2 0 0 1-2 2h-2M6 18v4h12v-4" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<!-- Pastikan SweetAlert2 sudah di-include di layout kamu -->


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let keranjang = [];

    function tambahKeKeranjang(id, nama, harga) {
        let item = keranjang.find(p => p.id === id);
        if (item) {
            item.jumlah++;
        } else {
            keranjang.push({ id, nama, harga, jumlah: 1 });
        }
        renderKeranjang();
    }

    function renderKeranjang() {
        let el = document.getElementById('keranjang');
        let total = 0;
        el.innerHTML = '';

        keranjang.forEach((item, index) => {
            let subtotal = item.harga * item.jumlah;
            total += subtotal;

            el.innerHTML += `
                <li class="flex justify-between items-center bg-gray-50 px-4 py-2 rounded-lg">
                    <div>
                        <div class="font-medium text-gray-800">${item.nama}</div>
                        <div class="text-sm text-gray-500">x${item.jumlah} @Rp ${item.harga.toLocaleString()}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-right text-green-600 font-semibold">Rp ${subtotal.toLocaleString()}</span>
                        <button onclick="hapusItem(${index})" class="text-red-500 hover:text-red-700 text-lg font-bold">×</button>
                    </div>
                </li>
            `;
        });

        document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString();
        updateKembalian();
    }

    function hapusItem(index) {
        keranjang.splice(index, 1);
        renderKeranjang();
    }

    function updateKembalian() {
        let bayar = parseInt(document.getElementById('uang_bayar').value || 0);
        let total = keranjang.reduce((sum, item) => sum + item.harga * item.jumlah, 0);
        let kembali = bayar - total;
        document.getElementById('kembalian').textContent = 'Rp ' + (kembali >= 0 ? kembali.toLocaleString() : '0');
    }

    document.getElementById('uang_bayar').addEventListener('input', updateKembalian);

    function refreshProduk() {
        fetch('/api/produk')
            .then(res => res.json())
            .then(produks => {
                const produkContainer = document.querySelector('.produk-list');
                produkContainer.innerHTML = '';

                produks.forEach(produk => {
                    produkContainer.innerHTML += `
                        <div class="bg-gray-50 hover:bg-white rounded-xl p-4 border hover:border-blue-400 cursor-pointer transition duration-200"
                            onclick="tambahKeKeranjang(${produk.id}, '${produk.nama}', ${produk.harga_jual})">
                            <h4 class="font-semibold text-lg text-gray-800">${produk.nama}</h4>
                            <p class="text-sm text-gray-500">Stok: <span class="stok-${produk.id}">${produk.stok}</span> ${produk.satuan}</p>
                            <p class="text-blue-600 font-bold text-base mt-2">Rp ${produk.harga_jual.toLocaleString()}</p>
                        </div>
                    `;
                });
            });
    }

    document.getElementById('btnSimpan').addEventListener('click', () => {
        if (keranjang.length === 0) {
            Swal.fire('Oops!', 'Keranjang masih kosong!', 'warning');
            return;
        }

        let total = keranjang.reduce((sum, item) => sum + item.harga * item.jumlah, 0);
        let bayar = parseInt(document.getElementById('uang_bayar').value || 0);
        let kembali = bayar - total;

        fetch("{{ route('kasir.simpanTransaksi') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                keranjang,
                total,
                uang_bayar: bayar,
                kembalian: kembali
            })
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                // Update stok produk real-time di UI
                res.updatedProduk.forEach(produk => {
                    const stokEl = document.querySelector(`.stok-${produk.id}`);
                    if (stokEl) stokEl.textContent = produk.stok;
                });

                // Reset keranjang & input
                keranjang = [];
                renderKeranjang();
                document.getElementById('uang_bayar').value = '';
                updateKembalian();

                Swal.fire({
                    icon: 'success',
                    title: 'Transaksi berhasil!',
                    text: 'Apakah kamu ingin mencetak struk sekarang?',
                    showCancelButton: true,
                    confirmButtonText: 'Cetak Struk',
                    cancelButtonText: 'Tutup'
                }).then(result => {
                    if (result.isConfirmed) {
                        cetakStruk(res.transaksi);
                    }
                });
            } else {
                Swal.fire('Gagal!', res.message || 'Terjadi kesalahan saat menyimpan transaksi.', 'error');
            }
        })
        .catch(() => {
            Swal.fire('Error!', 'Tidak dapat menghubungi server, coba lagi nanti.', 'error');
        });
    });

    function cetakStruk(transaksi) {
        let isiStruk = `
            <h2>Struk Transaksi</h2>
            <p>Tanggal: ${new Date(transaksi.tanggal).toLocaleString()}</p>
            <hr>
            <ul>
                ${transaksi.items ? transaksi.items.map(item => `
                    <li>${item.nama} x${item.jumlah} @Rp ${item.harga.toLocaleString()} = Rp ${(item.harga * item.jumlah).toLocaleString()}</li>
                `).join('') : ''}
            </ul>
            <hr>
            <p>Total: Rp ${transaksi.total.toLocaleString()}</p>
            <p>Bayar: Rp ${transaksi.uang_bayar.toLocaleString()}</p>
            <p>Kembalian: Rp ${transaksi.kembalian.toLocaleString()}</p>
        `;

        let printWindow = window.open('', '_blank', 'width=400,height=600');
        printWindow.document.write(`<html><head><title>Struk Transaksi</title></head><body>${isiStruk}</body></html>`);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }
    // FUNGSI LIVE SEARCH
document.getElementById('search').addEventListener('input', function () {
    const keyword = this.value.toLowerCase();
    const produkEls = document.querySelectorAll('.produk-list > div');

    produkEls.forEach(el => {
        const namaProduk = el.querySelector('h4').textContent.toLowerCase();
        if (namaProduk.includes(keyword)) {
            el.style.display = ''; // tampilkan
        } else {
            el.style.display = 'none'; // sembunyikan
        }
    });
});

</script>

@endsection
