@extends('layouts.auth')

@section('page-title')
    {{ __('Login') }}
@endsection

@section('content')
    <!-- Application container -->
    <div class="container-fluid container-application">
        <!-- Content -->
        <div class="main-content position-relative">
            <!-- Page content -->
            <div class="page-content">
                <div class="min-vh-100 py-5 d-flex align-items-center">
                    <div class="w-100">
                        <div class="row justify-content-center">
                            <div class="form-group auth-lang">                                
                                <select name="language" id="language" class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                    @foreach(\App\Utility::languages() as $language)
                                        <option @if($lang == $language) selected @endif value="{{ route('login', $language) }}">{{Str::upper($language)}}</option>
                                    @endforeach
                                </select>                                
                            </div>
                            <div class="col-sm-8 col-lg-4">
                                <div class="row justify-content-center mb-3">
                                    <a class="navbar-brand" href="#">
                                        <img src="{{ asset(Storage::url('uploads/logo/logo.png')) }}"  class="auth-logo" width="250" alt="{{ __('Company Logo') }}">
                                    </a>
                                </div>
                                <div class="card shadow zindex-100 mb-0">
                                    <div class="card-body px-md-5 pt-5">
                                        <div class="mb-5">
                                            <h6 class="h3">{{ __('Login') }}</h6>
                                            <p class="text-muted mb-0">{{ __('Sign in to your account to continue.') }}</p>
                                        </div>
                                        <span class="clearfix"></span>
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-control-label">{{ __('E-Mail Address') }}</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    </div>
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="form-group mb-4">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <label class="form-control-label">{{ __('Password') }}</label>
                                                    </div>
                                                    <div class="mb-2">
                                                        @if (Route::has('password.request'))
                                                            <a class="btn-link small text-muted text-underline--dashed border-primary" href="{{ route('password.request',$lang) }}">
                                                                {{ __('Forgot Your Password?') }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                    </div>
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row mb-0">
                                                <button type="submit" class="btn btn-sm btn-primary btn-icon rounded-pill login-do-btn">
                                                    <a href="#"><span class="btn-inner--text text-white">{{ __('Sign in') }}</span></a>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sidenav-mask mask-body d-xl-none" data-action="sidenav-unpin" data-target="undefined"></div><div class="sidenav-mask mask-body d-xl-none" data-action="sidenav-unpin" data-target="undefined"></div></div>
    </div>
@endsection