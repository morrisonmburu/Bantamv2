@extends('layouts.app')

@section('content')
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h2 class="logo-name">NH</h2>
            </div>
            <h3>Reset Password</h3>
            {{--<p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.--}}
            {{--<!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->--}}
            {{--</p>--}}
            <p>Send password reset link to my email</p>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="m-t" role="form"method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Send Password Reset Link</button>
                {{--<a  href="{{ route('password.request') }}"><small>Forgot password?</small></a>--}}
                {{--<p class="text-muted text-center"><small>Do not have an account?</small></p>--}}
                {{--<a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>--}}
            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>
@endsection
