@extends('layouts.basic')

@section('css')
    <link href="{{ Asset('css/login.css') }}" rel="stylesheet" />
@endsection

@section('main')
    <div class="container-fluid vh-100 overflow-hidden">
        <div class="row md-d-flex align-items-md-center">
            <div class="d-none d-md-block col-md-6 col-lg-6 px-0">
                <img src="{{ asset('img/contents/login.png')}}" alt="" class="vh-100" />
            </div>
            <div class="col-md-4 offset-md-1 form-box px-5">
                <h1 class="fw-bold mb-4 text-center text-md-start">
                    Masuk dengan akun Administrator
                </h1>
                <form action="{{url('/login')}}" method="post" class="d-flex flex-column">
                    @csrf
                    <div class="d-flex">
                        <div class="login-icons-box form-control text-center px-0">
                            <img src="{{ asset('img/icons/person-fill.svg') }}" alt="" class="d-flex login-icons" />
                        </div>
                        <input type="text" class="form-control" name="username" placeholder="Username" maxlength="20" required/>
                    </div>
                    <div class="d-flex mt-3">
                        <div class="login-icons-box form-control text-center px-0">
                            <img src="{{ asset('img/icons/password-lock.svg')}}" alt="" class="d-flex login-icons" />
                        </div>
                        <input type="password" class="form-control" name="password" maxlength="100" placeholder="Password" required/>
                    </div>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{$errors->first('message') }}
                        </div>
                    @endif
                    <input type="submit" class="form-control" value="Masuk" />
                </form>
            </div>
        </div>
    </div>

@endsection