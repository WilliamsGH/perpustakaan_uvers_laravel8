@extends('layouts.main')

@section('css')
    <link href="{{ Asset('css/biblio.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <main class="content">
        <div class="container-fluid">
            <form action="" method="POST" class="biblio-edit" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <h1 class="biblio fw-bold mb-3 px-0">Bibliography</h1>

                    <div class="col bg-white mb-3">
                        <div class="row">
                            <h3 class="biblio fw-bold px-3 px-md-4 py-2 shadow-lg">
                                Edit Buku
                            </h3>

                            <h4 class="biblio fw-bold px-4 px-md-5 pt-3">
                                Informasi Buku
                            </h4>

                            <div class="col-md-6 ps-4 pe-4 ps-md-5">
                                <label for="">Judul Buku</label>
                                <input type="text" class="form-control" name="name" value="{{ $book_id->name }}" />
                                <label for="">Penerbit</label>
                                <input type="text" class="form-control" name="publisher"
                                    value="{{ $book_id->publisher }}" />
                                <label for="">Kala Terbit</label>
                                <input type="text" class="form-control" name="publish_period"
                                    value="{{ $book_id->publish_period }}" />
                                <label for="">Tempat Terbit</label>
                                <input type="text" class="form-control" name="publish_place"
                                    value="{{ $book_id->publish_place }}" />
                                <label for="">Kategori Buku</label>
                                <select name="category_id" class="form-select" required>
                                    @foreach ($category_ids as $category_id)
                                        <option value="{{ $category_id->id }}"
                                            {{ $book_id->category_id == $category_id->id ? 'selected' : '' }}>
                                            {{ $category_id->name }}</option>
                                    @endforeach
                                </select>
                                <label for="">Bahasa</label>
                                <select name="language_id" class="form-select" required>
                                    @foreach ($language_ids as $language_id)
                                        <option value="{{ $language_id->id }}"
                                            {{ $book_id->language_id == $language_id->id ? 'selected' : '' }}>
                                            {{ $language_id->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 ps-4 pe-4 ps-md-0 pe-md-5">
                                <label for="">Pengarang</label>
                                <input type="text" class="form-control" name="writer" value="{{ $book_id->writer }}" />
                                <label for="">ISBN</label>
                                <input type="text" class="form-control" name="isbn" value="{{ $book_id->isbn }}" />
                                <label for="">Tahun Terbit</label>
                                <input type="text" class="form-control" name="publish_year"
                                    value="{{ $book_id->publish_year }}" />
                                <label for="">No Panggil</label>
                                <input type="text" class="form-control" name="internal_reference"
                                    value="{{ $book_id->internal_reference }}" />
                                <label for="">Tipe Buku</label>
                                <input type="text" class="form-control" name="type" value="{{ $book_id->type }}" />
                                <label for="">Stock Buku</label>
                                <input type="number" class="form-control" name="stock" value="{{ $book_id->stock }}"
                                    required />
                            </div>
                        </div>

                        <div class="row mt-2">
                            <h4 class="biblio fw-bold px-4 px-md-5 pt-3">
                                Deskripsi Buku
                            </h4>

                            <div class="col ps-4 pe-4 ps-md-5 pe-md-5">
                                <label>Sinopsis</label>
                                <textarea class="form-control" name="synopsis">{{ $book_id->synopsis }}</textarea>
                                <label for="">Gambar Sampul</label>
                                <input type="file" class="form-control" name="cover_file" />
                                <label for="">Lampiran Berkas/File</label>
                                <input type="file" class="form-control" name="book_file" />
                                <div class="mt-3">
                                    <input class="form-check-input" type="checkbox" name="is_publish" id="flexCheckChecked"
                                        {{ $book_id->is_publish ? 'checked' : '' }} />
                                    <label class="form-check-label text-dark" for="flexCheckChecked">
                                        Ingin menampilkan buku ini di aplikasi perpustakaan
                                    </label>
                                </div>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors }}
                            </div>
                        @endif
                        <div class="row my-4">
                            {{-- <div class="col-md-6">
                                <a href="{{ url('/bibliography') }}" class="d-flex btn biblio-btn-batal w-50 mx-auto me-md-0 justify-content-center">
                                    Batal
                                </a>
                            </div> --}}
                            <div class="col-md-6 mt-3 mt-md-0 text-center text-md-start">
                                <button type="submit" class="btn biblio-btn-simpan w-50">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection

@section('js')
@endsection
