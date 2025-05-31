<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5 bg-light min-vh-100">
        <div class="container">

            <div class="row g-4">
                <!-- Card Kasir -->
                <div class="col-12 col-md-6">
                    <a href="{{ route('kasir.dashboard') }}" class="text-decoration-none">
                        <div class="card shadow-sm h-100 hover-shadow border-0">
                            <div class="card-body d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-3 me-4">
                                    <!-- Icon Kasir (cash register) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                        <path d="M11 15a4 4 0 1 0-2-3.465V11a.5.5 0 0 0-1 0v.535A4 4 0 0 0 11 15Z"/>
                                        <path d="M9 10v.535A3.5 3.5 0 1 1 6 8a3.484 3.484 0 0 1 3 2Zm-.5-6a.5.5 0 0 1 1 0v1h-1v-1Z"/>
                                        <path d="M2 4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H2Zm12 7H2v-1h12v1Zm0-2H2v-2h12v2Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="card-title text-primary">Ke Halaman Kasir</h5>
                                    <p class="card-text text-secondary mb-0">Lakukan transaksi penjualan di sini.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card Admin -->
                <div class="col-12 col-md-6">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                        <div class="card shadow-sm h-100 hover-shadow border-0">
                            <div class="card-body d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle p-3 me-4">
                                    <!-- Icon Admin (gear) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                      <path d="M9.405 1.05a.5.5 0 0 0-.81 0l-1.287 2.024a5.37 5.37 0 0 0-1.8.93L4.688 2.26a.5.5 0 0 0-.868.5l.877 1.52a5.36 5.36 0 0 0-.895 1.805L1.05 6.594a.5.5 0 0 0 0 .812l2.027 1.283a5.36 5.36 0 0 0 .93 1.798l-1.522.874a.5.5 0 0 0 .5.868l1.522-.877a5.37 5.37 0 0 0 1.804.895l.877 1.522a.5.5 0 0 0 .868-.5l-1.52-.876a5.38 5.38 0 0 0 1.8-.93l1.29 2.03a.5.5 0 0 0 .81 0l1.285-2.027a5.38 5.38 0 0 0 1.8-.93l1.52.877a.5.5 0 0 0 .868-.5l-1.52-.877a5.367 5.367 0 0 0 .894-1.8l2.03-1.286a.5.5 0 0 0 0-.81l-2.027-1.29a5.367 5.367 0 0 0-.93-1.8l2.027-1.522a.5.5 0 0 0-.5-.868l-1.52.877a5.36 5.36 0 0 0-1.798-.895L9.405 1.05Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="card-title text-success">Ke Halaman Admin</h5>
                                    <p class="card-text text-secondary mb-0">Kelola pengguna dan sistem aplikasi.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="mt-5 text-center text-muted">
                {{ __("You're logged in!") }}
            </div>

        </div>
    </div>
</x-app-layout>
