@extends('layouts.auth')

@section('page-title')
    {{ __('Registration') }}
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
                                        <option @if($lang == $language) selected @endif value="{{ route('register', $language) }}">{{Str::upper($language)}}</option>
                                    @endforeach
                                </select>                                
                            </div>
                            <div class="col-sm-8 col-lg-5">
                                <div class="row justify-content-center mb-3">
                                    <a class="navbar-brand" href="#">
                                        <img src="{{ asset(Storage::url('uploads/logo/logo.png')) }}"  class="auth-logo" width="250" alt="{{ __('Company Logo') }}">
                                    </a>
                                </div>
                                <div class="card shadow zindex-100 mb-0">
                                    <div class="card-body px-md-5 py-5">
                                        <div >
                                            <div class="mb-5">
                                                <h6 class="h3">{{ __('Create account') }}</h6>
                                                <p class="text-muted mb-0">{{ __("Don't have an account? Create your account, it takes less than a minute") }}</p>
                                            </div>
                                            <span class="clearfix"></span>
                                            <form method="POST" action="{{ route('register') }}" role="form">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label">{{ __('First Name') }}</label>
                                                            <div class="input-group input-group-merge">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                                </div>
                                                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                                                @error('first_name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label">{{ __('Last Name') }}</label>
                                                            <div class="input-group input-group-merge">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                                </div>
                                                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                                                                @error('last_name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-control-label">{{ __('Company Name') }}</label>
                                                            <div class="input-group input-group-merge">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="name" autofocus>
                                                                @error('company_name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-control-label">{{ __('Email') }}</label>
                                                            <div class="input-group input-group-merge">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                                </div>
                                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                                                @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-control-label">{{ __('Password') }}</label>
                                                            <div class="input-group input-group-merge">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                                </div>
                                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                                                @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-control-label">{{ __('Confirm Password') }}</label>
                                                            <div class="input-group input-group-merge">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                                </div>
                                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="mt-4">
                                                            <button type="submit" class="btn btn-sm btn-primary btn-icon rounded-pill">
                                                                <span class="btn-inner--text">{{ __('Create my account') }}</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>




                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-footer px-md-5"><small>{{ __('Already have an acocunt?') }}</small>
                                        <a href="{{ url('login',$lang) }}" class="small font-weight-bold">{{ __('Sign in') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
