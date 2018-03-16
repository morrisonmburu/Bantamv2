@extends('layouts.app')
@section('content')
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h2 class="logo-name">NH</h2>
            </div>
            <h3>Welcome to ESS</h3>
            {{--<p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.--}}
            {{--<!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->--}}
            {{--</p>--}}
            <p>Login in. To see it in action.</p>
            <form class="m-t" role="form" method="POST" action="{{ route('password.request') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" name="email" value="{{ $email or old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <input id="password-confirm" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="Confirm Password" name="password_confirmation" required>

                    @if ($errors->has('password_confirmation'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Reset Password</button>
            </form>
            <p class="m-t"> <small>The Nairobi Hospital Copyright ©2018 all rights reserved</small> </p>
        </div>
    </div>
@endsection
