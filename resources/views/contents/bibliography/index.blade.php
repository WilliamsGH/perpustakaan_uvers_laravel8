@extends('layouts.main')

@section('css')
    <link href="{{ asset('css/biblio.css') }}" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('content')
    <!-- Content -->
    <main class="content">
        <div class="container-fluid">
            <div class="row">
                <h1 class="biblio fw-bold mb-3 px-0">Bibliography</h1>

                <div class="col min-vh-70 bg-white mb-3 p-0">
                    <div class="py-2 py-sm-4 px-4 d-sm-flex shadow-lg">
                        <form action="" class="d-flex biblio-form-search">
                            <div
                                class="biblio-search-icon-box bg-white h-100 d-flex justify-content-center align-items-center">
                                <img src="{{ Asset('img/icons/search.svg') }}" alt="" class="" />
                            </div>
                            <input type="text" class="biblio-form-pencarian" placeholder="Pencarian data" />
                        </form>

                        <a href="{{ url('/bibliography/create') }}"
                            class="biblio-tambah-buku-box text-decoration-none ms-sm-auto d-flex justify-content-center align-items-center mt-2 mt-sm-0">
                            <img src="{{ Asset('img/icons/plus.svg') }}" alt="" />
                            <div class="mx-2 fw-normal">Tambah buku</div>
                        </a>
                    </div>

                    <div class="table-responsive px-3 px-sm-4">
                        <table class="table biblio-table text-black table-border-bottom">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Pengarang</th>
                                    <th scope="col">Penerbit</th>
                                    <th scope="col tahun-terbit">Tahun Terbit</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($book_ids as $book_id)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $book_id->name }}</td>
                                        <td>{{ $book_id->writer }}</td>
                                        <td>{{ $book_id->publisher }}</td>
                                        <td>{{ $book_id->publish_year }}</td>
                                        <td>
                                            <div class="d-md-flex gap-1">
                                                <a href="{{ url('/bibliography/edit/' . $book_id->id) }}"
                                                    class="d-inline-block pb-1 pb-md-0">
                                                    <img src="{{ Asset('img/icons/edit.svg') }}" alt=""
                                                        class="biblio-btn-aksi" />
                                                </a>
                                                <form action="{{ url('/bibliography/delete/' . $book_id->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <button class="btn d-inline-block pt-1 pt-md-0" type="submit">
                                                        <img src="{{ Asset('img/icons/delete.svg') }}"
                                                            alt="" class="biblio-btn-aksi" />
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End Content -->

    <!-- Modal (Alert) Konfirmasi -->
    <div class="modal fade" id="alert-hapus-biblio" tabindex="-1" aria-labelledby="modal-detail-informasi-label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex flex-row w-100 py-4">
                        <div class="d-flex justify-content-center align-items-center biblio-img-konfirmasi-box">
                            <img src="{{ Asset('img/icons/confirmation.svg') }}" class="biblio-img-konfirmasi" />
                        </div>
                        <div class="d-flex flex-column justify-content-center biblio-btn-konfirmasi-box">
                            <div class="biblio-text-konfirmasi text-center px-2">
                                Apakah Anda yakin ingin menghapus file Pengenalan
                                Dasar...?
                            </div>
                            <div class="text-center mt-3">
                                <button class="btn btn-konfirmasi-batal me-1" data-bs-dismiss="modal">
                                    Batal
                                </button>
                                <button href="" class="btn btn-konfirmasi-hapus ms-1">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal (Alert) Dihapus -->
    <div class="modal fade" id="alert-biblio-dihapus" tabindex="-1" aria-labelledby="modal-detail-informasi-label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex flex-row w-100 py-4">
                        <div class="d-flex justify-content-center align-items-center biblio-img-dihapus-box">
                            <img src="img/icons/trash-files.svg" class="biblio-img-dihapus" />
                        </div>
                        <div class="d-flex flex-column justify-content-center text-center biblio-text-dihapus px-2">
                            File Pengenalan Dasar... sudah terhapus.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const alertHapusBiblio = new bootstrap.Modal('#alert-hapus-biblio', {
            keyboard: true,
        })

        document.querySelectorAll('.hapus-biblio').forEach((row) => {
            row.addEventListener('click', (event) => {
                event.stopPropagation()
                alertHapusBiblio.show()
            })
        })

        const alertBiblioDihapus = new bootstrap.Modal('#alert-biblio-dihapus', {
            keyboard: true,
        })

        const btnKonfirmasiHapus = document.querySelector('.btn-konfirmasi-hapus')
        btnKonfirmasiHapus.addEventListener('click', (event) => {
            event.stopPropagation()
            alertHapusBiblio.hide()
            alertBiblioDihapus.show()
        })
    </script>
    <script>
        $(document).ready(function() {
            $(".biblio-form-pencarian").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".biblio-table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
