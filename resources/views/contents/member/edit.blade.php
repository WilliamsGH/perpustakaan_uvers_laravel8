@extends('layouts.main')

@section('css')
<link href="{{ asset('css/anggota.css') }}" rel="stylesheet" />
@endsection

@section('content')
<main class="content">
  <div class="container-fluid">
    <div class="row">
      <h1 class="anggota fw-bold mb-3 px-0">Anggota</h1>

      <div class="col min-vh-70 bg-white mb-3 p-0">
        <h3 class="anggota fw-bold px-3 px-md-4 py-2 shadow-lg">
          Edit Anggota
        </h3>

        <form action="" method="POST" class="anggota-edit px-4">
          @csrf
          <div class="row mt-2">
            <div class="row mt-2">
              <div class="col-md-6 mb-md-2">
                <label for="">ID Anggota</label>
                <input type="text" class="form-control" name="username" value="{{ $user_id->username }}" required />
                <label for="">No.Telepon</label>
                <input type="tel" class="form-control" name="phone" value="{{ $user_id->phone }}" required />
                <label for="">Password</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="password" name="password">
                  <div class="input-group-append">
                    <span class="input-group-text h-100" onclick="password_show_hide();">
                      <i class="fas fa-eye" id="show_eye"></i>
                      <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                    </span>
                  </div>
                </div>
                <label for="">Email</label>
                <input type="email" class="form-control" name="email" value="{{ $user_id->email }}"  required />
                <label for="">Alamat Rumah</label>
                <input type="text" class="form-control" name="address" value="{{ $user_id->address }}"  required />
                <label for="">Jenis Kelamin</label>
                <div class="form-control">
                  <input class="form-check-input" type="radio" name="gender" value="female" id="flexRadioDefault1"
                    {{ ($user_id->gender == 'female') ? 'checked' : ''; }} required/>
                  <label class="form-check-label mx-2" for="flexRadioDefault1">
                    Perempuan
                  </label>
                </div>
                <div class="form-control mt-2">
                  <input class="form-check-input" type="radio" name="gender" value="male" id="flexRadioDefault2"
                    {{ ($user_id->gender == 'male') ? 'checked' : ''; }} required/>
                  <label class="form-check-label mx-2" for="flexRadioDefault2">
                    Laki-laki
                  </label>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Nama Anggota</label>
                <input type="text" class="form-control" name="name" value="{{ $user_id->name }}" required />
                <label for="">Tanggal Bergabung</label>
                <input type="date" class="form-control" name="join_date"
                  value="{{ \Carbon\Carbon::parse($user_id->join_date)->format('Y-m-d') }}" required />
                <label for="">Asal Sekolah / Universitas</label>
                <select name="institution_id" class="form-select" required>
                  @foreach ($institution_ids as $institution_id)
                  <option value="{{ $institution_id->id }}" {{ ($user_id->institution_id ==
                    $institution_id->id) ?
                    'selected' : ''; }}>{{ $institution_id->name }}</option>
                  @endforeach
                </select>
                {{-- <label for="">Fakultas</label>
                <input type="text" class="form-control" name="" readonly /> --}}
                <label for="">Jurusan</label>
                <select name="major_id" class="form-select" id="major_id" required>
                  @foreach ($major_ids as $institution_id)
                  <option value="{{ $institution_id->id }}">{{ $institution_id->name }}</option>
                  @endforeach
                </select>
                <label for="">Angkatan</label>
                <input type="text" class="form-control" name="generation" value="{{ $user_id->generation }}" required />
              </div>
            </div>

            <div class="row mt-2">
              <div class="col">
                <input class="form-check-input" type="checkbox" name="active" {{ (!$user_id->active) ?
                'checked' : ''; }}
                id="flexCheckChecked" />
                <label class="form-check-label text-dark" for="flexCheckChecked">
                  Nonaktifkan anggota tersebut
                </label>
              </div>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger">
              {{ $errors }}
            </div>
            @endif

            <div class="row mt-3">
              <div class="col-md-6 text-center mx-auto text-md-end">
                <a href="{{ url('member') }}" class="btn anggota-btn-batal w-50">
                  Batal
                </a>
              </div>
              <div class="col-md-6 mt-3 mt-md-0 text-center text-md-start">
                <button type="submit" class="btn anggota-btn-simpan w-50">
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
<script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');
  togglePassword.addEventListener('click', () => {
  const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
  password.setAttribute('type', type);
  this.classList.toggle('bi bi-eye');
  this.classList.toggle('bi bi-eye-slash');
  });

  function password_show_hide() {
  var x = document.getElementById("password");
  var show_eye = document.getElementById("show_eye");
  var hide_eye = document.getElementById("hide_eye");
  hide_eye.classList.remove("d-none");
  if (x.type === "password") {
    x.type = "text";
    show_eye.style.display = "none";
    hide_eye.style.display = "block";
  } else {
    x.type = "password";
    show_eye.style.display = "block";
    hide_eye.style.display = "none";
  }
}
</script>
@endsection