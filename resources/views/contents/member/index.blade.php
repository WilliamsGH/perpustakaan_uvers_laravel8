@extends('layouts.main')

@section('css')
    <link href="{{ asset('css/anggota.css') }}" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="row">
                <h1 class="anggota fw-bold mb-3 px-0">Anggota</h1>

                <div class="col min-vh-70 bg-white mb-3 p-0">
                    <div class="py-2 py-sm-4 px-4 d-sm-flex shadow-lg">
                        <form action="" class="d-flex anggota-form-search">
                            <div
                                class="anggota-search-icon-box bg-white h-100 d-flex justify-content-center align-items-center">
                                <img src="{{ Asset('img/icons/search.svg') }}" alt="" class="" />
                            </div>
                            <input type="text" class="anggota-form-pencarian" placeholder="Pencarian data" />
                        </form>

                        <a href="{{ url('member/create') }}"
                            class="anggota-tambah-anggota-box text-decoration-none ms-sm-auto d-flex justify-content-center align-items-center mt-2 mt-sm-0">
                            <img src="{{ Asset('img/icons/plus.svg') }}" alt="" />
                            <div class="mx-2 fw-normal">Tambah anggota</div>
                        </a>
                    </div>

                    <div class="table-responsive px-3 px-sm-4">
                        <table class="table anggota-table text-black table-border-bottom">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Prodi</th>
                                    <th scope="col">Angkatan</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user_ids as $user_id)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user_id->username }}</td>
                                        <td>{{ $user_id->name }}</td>
                                        <td>{{ @$user_id->major->name }}</td>
                                        <td>{{ $user_id->generation }}</td>
                                        <td>
                                            <div class="d-md-flex gap-1">
                                                <a href="{{ url('/member/edit/' . $user_id->id) }}"
                                                    class="d-inline-block pb-1 pb-md-0">
                                                    <img src="{{ Asset('img/icons/edit.svg') }}" alt=""
                                                        class="anggota-btn-aksi" />
                                                </a>
                                                <form action="{{ url('/member/delete/' . $user_id->id) }}" method="post">
                                                    @csrf
                                                    <button class="btn d-inline-block pt-1 pt-md-0" type="submit">
                                                        <img src="{{ Asset('img/icons/delete.svg') }}"
                                                            alt="" class="anggota-btn-aksi" />
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

    <!-- Modal (Alert) Konfirmasi -->
    <div class="modal fade" id="alert-hapus-anggota" tabindex="-1" aria-labelledby="modal-detail-informasi-label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex flex-row w-100 py-4">
                        <div class="d-flex justify-content-center align-items-center anggota-img-konfirmasi-box">
                            <img src="{{ Asset('img/icons/confirmation.svg') }}" class="anggota-img-konfirmasi" />
                        </div>
                        <div class="d-flex flex-column justify-content-center anggota-btn-konfirmasi-box">
                            <div class="anggota-text-konfirmasi text-center px-2">
                                Apakah Anda yakin ingin menghapus anggota Dianne?
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
    <div class="modal fade" id="alert-anggota-dihapus" tabindex="-1" aria-labelledby="modal-detail-informasi-label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex flex-row w-100 py-4">
                        <div class="d-flex justify-content-center align-items-center anggota-img-dihapus-box">
                            <img src="{{ Asset('img/icons/trash-members.svg') }}" class="anggota-img-dihapus" />
                        </div>
                        <div class="d-flex flex-column justify-content-center text-center anggota-text-dihapus px-2">
                            Anggota Dianne sudah terhapus.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const alertHapusAnggota = new bootstrap.Modal('#alert-hapus-anggota', {
            keyboard: true,
        })

        document.querySelectorAll('.hapus-anggota').forEach((row) => {
            row.addEventListener('click', (event) => {
                event.stopPropagation()
                alertHapusAnggota.show()
            })
        })

        const alertAnggotaDihapus = new bootstrap.Modal(
            '#alert-anggota-dihapus', {
                keyboard: true,
            }
        )

        const btnKonfirmasiHapus = document.querySelector('.btn-konfirmasi-hapus')
        btnKonfirmasiHapus.addEventListener('click', (event) => {
            event.stopPropagation()
            alertHapusAnggota.hide()
            alertAnggotaDihapus.show()
        })
    </script>
    <script>
        $(document).ready(function() {
            $(".anggota-form-pencarian").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".anggota-table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
