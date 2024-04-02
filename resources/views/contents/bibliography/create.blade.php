@extends('layouts.main')

@section('css')
    <link href="{{ Asset('css/biblio.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="row">
                <h1 class="biblio fw-bold mb-3 px-0">Bibliography</h1>
                <div class="col bg-white mb-3">
                    <form action="{{ url('/bibliography/store') }}" method="POST" class="biblio-tambah" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <h3 class="biblio fw-bold px-3 px-md-4 py-2 shadow-lg">
                                Tambah Buku
                            </h3>

                            <h4 class="biblio fw-bold px-4 px-md-5 pt-3">
                                Informasi Buku
                            </h4>

                            <div class="col-md-6 ps-4 pe-4 ps-md-5">
                                <label for="">Judul Buku</label>
                                <input type="text" class="form-control" name="name" required/>
                                <label for="">Penerbit</label>
                                <input type="text" class="form-control" name="publisher" required/>
                                <label for="">Kala Terbit</label>
                                <input type="text" class="form-control" name="publish_period" required/>
                                <label for="">Tempat Terbit</label>
                                <input type="text" class="form-control" name="publish_place" required/>
                                <label for="">Kategori Buku</label>
                                <select name="category_id" class="form-select" required>
                                    @foreach ($category_ids as $category_id)
                                        <option value="{{$category_id->id}}">{{$category_id->name}}</option>
                                    @endforeach
                                </select>
                                <label for="">Bahasa</label>
                                <select name="language_id" class="form-select" required>
                                    @foreach ($language_ids as $language_id)
                                        <option value="{{$language_id->id}}">{{$language_id->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 ps-4 pe-4 ps-md-0 pe-md-5">
                                <label for="">Pengarang</label>
                                <input type="text" class="form-control" name="writer" required/>
                                <label for="">ISBN</label>
                                <input type="text" class="form-control" name="isbn" required/>
                                <label for="">Tahun Terbit</label>
                                <input type="text" class="form-control" name="publish_year" required/>
                                <label for="">No Panggil</label>
                                <input type="text" class="form-control" name="internal_reference" required/>
                                <label for="">Tipe Buku</label>
                                <input type="text" class="form-control" name="type" required/>
                                <label for="">Stock Buku</label>
                                <input type="number" class="form-control" name="stock" required/>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <h4 class="biblio fw-bold px-4 px-md-5 pt-3">
                                Deskripsi Buku
                            </h4>

                            <div class="col ps-4 pe-4 ps-md-5 pe-md-5">
                                <label>Sinopsis</label>
                                <textarea class="form-control" name="synopsis" required></textarea>
                                <label for="">Gambar Sampul</label>
                                <input type="file" class="form-control" name="cover_file" required/>
                                <label for="">Lampiran Berkas/File</label>
                                <input type="file" class="form-control" name="book_file" required/>
                                <div class="mt-3">
                                    <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="is_publish" checked />
                                    <label class="form-check-label text-dark" for="flexCheckChecked">
                                        Ingin menampilkan buku ini di aplikasi perpustakaan
                                    </label>
                                </div>
                            </div>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                {{$errors }}
                            </div>
                        @endif
                        <div class="row my-4">
                            <div class="col-md-6">
                                <a href="" class="d-flex">
                                    <button class="btn biblio-btn-batal w-50 mx-auto me-md-0">
                                        Batal
                                    </button>
                                </a>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0 text-center text-md-start">
                                <button type="submit" class="btn biblio-btn-simpan w-50">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')
@endsection
